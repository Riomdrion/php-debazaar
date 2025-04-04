<?php

namespace App\Http\Controllers;

use App\Models\Advertentie;
use App\Models\VerhuurAdvertentie;
use App\Models\AdvertentieKoppeling;
use App\Models\WearSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// Voor QR-code
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class CsvImportController extends Controller
{
    /**
     * Toon het formulier voor CSV-upload.
     * Voorbeeld-URL: /advertenties/csv-import/verhuur/create
     */
    public function create($type)
    {
        return view('csv-import.create', compact('type'));
    }

    /**
     * Verwerk het geüploade CSV-bestand en sla de records op.
     */
    public function store(Request $request, $type)
    {
        // Validatie: alleen CSV of txt
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        // Opslaan van het bestand in /storage/temp
        $csvPath = $request->file('csv_file')->store('temp');

        // Openen van het bestand om te parsen
        if (($handle = fopen(Storage::path($csvPath), 'r')) === false) {
            return back()->withErrors(['Bestand kan niet worden geopend.']);
        }

        // Eventueel de eerste rij overslaan als dat kolom-headers zijn
        // fgetcsv($handle);

        // Teller voor aantal succesvol aangemaakte advertenties
        $createdCount = 0;

        // Voorbeeld van kolommen die we in de CSV verwachten
        // (pas aan aan jouw eigen kolommen)
        // - titel
        // - beschrijving
        // - prijs/dagprijs/enz.
        // - borg (alleen voor verhuur)
        // - is_actief
        // - etc...
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            // Kolommen mappen (afhankelijk van je CSV)
            // Let op: bij te weinig kolommen -> controle + overslaan.
            $titel       = $data[0] ?? null;
            $beschrijving= $data[1] ?? null;
            $prijs       = $data[2] ?? null;  // Dagprijs of koopprijs
            $borg        = $data[3] ?? null;  // Alleen relevant bij verhuur

            // Als een van de verplichte velden ontbreekt, skip
            if (!$titel || !$beschrijving || !$prijs) {
                // Je kunt evt. loggen dat een regel is overgeslagen
                continue;
            }

            // 1) Controleer op limiet (max. 4 advertenties of max. 4 verhuuradvertenties)
            //    Voorkomen dat we over de limiet gaan.
            //    Je zou dit ook vóór de loop kunnen checken, maar dan kun je niet deels importeren.
            if ($type === 'verhuur') {
                if (Auth::user()->verhuurAdvertenties()->count() >= 4) {
                    // Geen nieuwe verhuuradvertentie meer mogelijk
                    break;
                }

                // 2) Valideren/opslaan (kopie van je store-logic uit VerhuurAdvertentieController)
                $verhuurAdvertentie = new VerhuurAdvertentie();
                $verhuurAdvertentie->titel        = $titel;
                $verhuurAdvertentie->beschrijving = $beschrijving;
                $verhuurAdvertentie->dagprijs     = (float)$prijs; // hier is prijs de dagprijs
                $verhuurAdvertentie->borg         = (float)$borg;
                $verhuurAdvertentie->user_id      = Auth::id();
                // Als je CSV een kolom had voor is_actief
                // $verhuurAdvertentie->is_actief = (bool)$data[4];
                $verhuurAdvertentie->save();

                // QR-code genereren
                $qrCode  = new QrCode(route('verhuuradvertenties.show', $verhuurAdvertentie->id));
                $writer  = new PngWriter();
                $result  = $writer->write($qrCode);
                $filename = 'qrcodes/' . Str::uuid() . '.png';
                $path = public_path($filename);
                $result->saveToFile($path);

                $verhuurAdvertentie->qr_code = 'storage/' . $filename;
                $verhuurAdvertentie->save();

                // WearSettings aanmaken
                WearSetting::create([
                    'verhuur_advertentie_id' => $verhuurAdvertentie->id,
                    'slijtage_per_dag' => 1.0,
                    'slijtage_per_verhuur' => 2.0,
                    'categorie_modifier' => 1.0,
                ]);

                $createdCount++;
            } else {
                // Gaan we ervan uit dat $type === 'normaal' (of iets anders voor de ‘gewone’ advertentie)
                // Check limiet
                if (Auth::user()->advertenties()->count() >= 4) {
                    // Geen nieuwe 'gewone' advertentie meer mogelijk
                    break;
                }

                // 2) Opslaan (kopie van je store-logic uit AdvertentieController)
                $advertentie = Auth::user()->advertenties()->create([
                    'titel'       => $titel,
                    'beschrijving'=> $beschrijving,
                    'prijs'       => (float)$prijs,
                ]);

                // QR-code genereren
                $qrCode = new QrCode(route('advertenties.show', $advertentie->id));
                $writer = new PngWriter();
                $result = $writer->write($qrCode);

                // Zorg ervoor dat map bestaat (public/qrcodes)
                if (!file_exists(public_path('qrcodes'))) {
                    mkdir(public_path('qrcodes'), 0755, true);
                }

                // Opslaan direct in public map
                $filename = 'qrcodes/' . Str::uuid() . '.png';
                $path = public_path($filename);
                $result->saveToFile($path);

                // URL opslaan
                $advertentie->qr_code = $filename;
                $advertentie->save();


                // Als je koppelingen wilt verwerken, moet je de IDs uit CSV halen
                // en net zoals in je store()-methode van Advertentie afhandelen

                $createdCount++;
            }
        }

        fclose($handle);
        Storage::delete($csvPath);

        return redirect()
            ->back()
            ->with('success', "$createdCount record(s) geïmporteerd voor type: $type.");
    }
}
