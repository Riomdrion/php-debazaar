<?php

namespace App\Http\Controllers;

use App\Models\VerhuurAdvertentie;
use App\Models\AdvertentieKoppeling;
use App\Models\WearSetting;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VerhuurAdvertentieController extends Controller
{
    public function index(Request $request)
    {
        // Haal de zoekterm op uit de request
        $zoekTerm = $request->input('zoek', '');

        // Start met een basisquery
        $query = VerhuurAdvertentie::query();

        // Voeg een zoekfunctie toe indien er een zoekterm is
        if ($zoekTerm !== '') {
            $query->where('titel', 'like', '%' . $zoekTerm . '%');
        }

        // Filter op actieve advertenties
        $query->where('is_actief', true);

        // Sorteer op aanmakingsdatum
        $verhuuradvertenties = $query->orderBy('created_at', 'desc')->paginate(12);

        // Retourneer de view met gepagineerde resultaten
        return view('verhuuradvertenties.index', compact('verhuuradvertenties'));
    }

    public function create()
    {
        return view('verhuuradvertenties.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->verhuurAdvertenties()->count() >= 4) {
            return redirect()->route('verhuuradvertenties.index')
                ->withErrors(['Je mag maximaal 4 verhuuradvertenties aanmaken.']);
        }

        $validated = $request->validate([
            'titel' => 'required|string|max:255',
            'beschrijving' => 'required|string',
            'dagprijs' => 'required|numeric|min:0',
            'borg' => 'required|numeric|min:0',
            'is_actief' => 'sometimes|boolean',
            'vervangingswaarde' => 'nullable|numeric|min:0'
        ]);

        $verhuurAdvertentie = new VerhuurAdvertentie($validated);
        $verhuurAdvertentie->user_id = Auth::id();
        $verhuurAdvertentie->is_actief = $request->has('is_actief');
        $verhuurAdvertentie->save();

        // ✅ QR-code correct opbouwen (v5-stijl)
        $qrCode = (new QrCode(route('advertenties.show', $verhuurAdvertentie->id)));

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $filename = 'qrcodes/' . Str::uuid() . '.png';
        $path = storage_path('app/public/' . $filename);
        $result->saveToFile($path);

        $verhuurAdvertentie->qr_code = 'storage/' . $filename;
        $verhuurAdvertentie->save();

        // automatiche aanmaken van de wear settings
        WearSetting::create([
            'verhuur_advertentie_id' => $verhuurAdvertentie->id,
            'slijtage_per_dag' => 1.0,
            'slijtage_per_verhuur' => 2.0,
            'categorie_modifier' => 1.0,
        ]);

        return redirect()->route('verhuuradvertenties.show', $verhuurAdvertentie)->with('success', 'Advertentie bijgewerkt!');
    }

    public function show($id)
    {
        $verhuurAdvertentie = VerhuurAdvertentie::with([
            'agendaItems',
            'agendaItems.rental',
            'user.bedrijf',
            'favorieten'
        ])->findOrFail($id);

        $isFavoriet = $verhuurAdvertentie->favorieten->contains('user_id', Auth::id());

        return view('verhuuradvertenties.show', compact('verhuurAdvertentie', 'isFavoriet'));
    }



    public function edit($id)
    {
        $verhuurAdvertentie = VerhuurAdvertentie::findOrFail($id);

        $slijtage = WearSetting::where('verhuur_advertentie_id', $id)->first();
        return view('verhuuradvertenties.edit', compact('verhuurAdvertentie', 'slijtage'));
    }

    public function update(Request $request, VerhuurAdvertentie $verhuurAdvertentie)
    {
        $validated = $request->validate([
            'titel' => 'required|string|max:255',
            'beschrijving' => 'required|string',
            'dagprijs' => 'required|numeric|min:0',
            'borg' => 'required|numeric|min:0',
            'is_actief' => 'sometimes|boolean',
            'vervangingswaarde' => 'nullable|numeric|min:0',
        ]);

        $verhuurAdvertentie->fill($validated);
        $verhuurAdvertentie->user_id = auth()->id();
        $verhuurAdvertentie->is_actief = $request->has('is_actief');
        $verhuurAdvertentie->save();

        return redirect()->route('verhuuradvertenties.show', $verhuurAdvertentie)->with('success', 'Advertentie bijgewerkt!');
    }


    public function destroy($id)
    {
        $verhuurAdvertentie = VerhuurAdvertentie::findOrFail($id);
        $verhuurAdvertentie->delete();
        return redirect()->route('verhuuradvertenties.index')->with('success', 'Advertentie verwijderd.');
    }
}
