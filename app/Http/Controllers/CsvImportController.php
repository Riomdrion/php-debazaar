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

        $createdCount = 0;

        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $titel = $data[0] ?? null;
            $beschrijving = $data[1] ?? null;
            $dagprijs = $data[2] ?? null;
            $borg = $data[3] ?? null;
            $vervangingswaarde = $data[4] ?? null;

            // Verplicht velden controleren voor verhuuradvertentie
            if ($type === 'verhuuradvertenties' && (!$titel || !$beschrijving || !$dagprijs || !$borg || !$vervangingswaarde)) {
                continue;
            }

            // Verplicht velden controleren voor normale advertentie
            if ($type !== 'verhuuradvertenties' && (!$titel || !$beschrijving || !$dagprijs)) {
                continue;
            }

            if ($type === 'verhuuradvertenties') {
                if (Auth::user()->verhuurAdvertenties()->count() >= 4) {
                    break;
                }

                $verhuurAdvertentie = new VerhuurAdvertentie();
                $verhuurAdvertentie->titel = $titel;
                $verhuurAdvertentie->beschrijving = $beschrijving;
                $verhuurAdvertentie->dagprijs = (float)$dagprijs;
                $verhuurAdvertentie->borg = (float)$borg;
                $verhuurAdvertentie->vervangingswaarde = (float)$vervangingswaarde;
                $verhuurAdvertentie->user_id = Auth::id();
                $verhuurAdvertentie->is_actief = true;
                $verhuurAdvertentie->save();

                // QR-code genereren en opslaan
                $qrCode = new QrCode(route('verhuuradvertenties.show', $verhuurAdvertentie->id));
                $writer = new PngWriter();
                $result = $writer->write($qrCode);

                if (!file_exists(public_path('qrcodes'))) {
                    mkdir(public_path('qrcodes'), 0755, true);
                }

                $filename = 'qrcodes/' . Str::uuid() . '.png';
                $path = public_path($filename);
                $result->saveToFile($path);

                $verhuurAdvertentie->qr_code = $filename;
                $verhuurAdvertentie->save();

                WearSetting::create([
                    'verhuur_advertentie_id' => $verhuurAdvertentie->id,
                    'slijtage_per_dag' => 1.0,
                    'slijtage_per_verhuur' => 2.0,
                    'categorie_modifier' => 1.0,
                ]);

                $createdCount++;
            } else {
                if (Auth::user()->advertenties()->count() >= 4) {
                    break;
                }

                $advertentie = Auth::user()->advertenties()->create([
                    'titel' => $titel,
                    'beschrijving' => $beschrijving,
                    'prijs' => (float)$dagprijs,
                ]);

                $qrCode = new QrCode(route('advertenties.show', $advertentie->id));
                $writer = new PngWriter();
                $result = $writer->write($qrCode);

                if (!file_exists(public_path('qrcodes'))) {
                    mkdir(public_path('qrcodes'), 0755, true);
                }

                $filename = 'qrcodes/' . Str::uuid() . '.png';
                $path = public_path($filename);
                $result->saveToFile($path);

                $advertentie->qr_code = $filename;
                $advertentie->save();

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
