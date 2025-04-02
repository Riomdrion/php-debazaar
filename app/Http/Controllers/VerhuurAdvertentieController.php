<?php

namespace App\Http\Controllers;

use App\Models\VerhuurAdvertentie;
use App\Models\AdvertentieKoppeling;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VerhuurAdvertentieController extends Controller
{
    public function index(Request $request)
    {
        $query = VerhuurAdvertentie::query();

        // Optioneel: filteren op titel of iets anders
        if ($request->filled('zoek')) {
            $query->where('titel', 'like', '%' . $request->zoek . '%');
        }
        $verhuuradvertenties = $query->orderBy('created_at', 'desc')->paginate(10);
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

        return redirect()->route('verhuuradvertenties.show', $verhuurAdvertentie)->with('success', 'Advertentie bijgewerkt!');
    }

    public function show($id)
    {
        $verhuurAdvertentie = VerhuurAdvertentie::with(['agendaItems', 'user.bedrijf', 'favorieten'])->findOrFail($id);

        $isFavoriet = $verhuurAdvertentie->favorieten->contains('user_id', Auth::id());

        return view('verhuuradvertenties.show', compact('verhuurAdvertentie', 'isFavoriet'));
    }


    public function edit($id)
    {
        $verhuurAdvertentie = VerhuurAdvertentie::findOrFail($id);
        return view('verhuuradvertenties.edit', compact('verhuurAdvertentie'));
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
