<?php

namespace App\Http\Controllers;

use App\Models\Advertentie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Illuminate\Support\Str;

class AdvertentieController extends Controller
{
    public function index(Request $request)
    {
        $query = Advertentie::query();

        // Optioneel: filteren op titel of iets anders
        if ($request->filled('zoek')) {
            $query->where('titel', 'like', '%' . $request->zoek . '%');
        }

        $advertenties = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('advertenties.index', compact('advertenties'));
    }

    public function create()
    {
        if (auth()->user()->advertenties()->count() >= 4) {
            return redirect()->route('advertenties.index')
                ->withErrors(['Je mag maximaal 4 advertenties aanmaken.']);
        }

        // Haal alle advertenties op behalve die van de huidige gebruiker
        $alleAdvertenties = Advertentie::where('user_id', '!=', auth()->id())->get();

        return view('advertenties.create', compact('alleAdvertenties'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->advertenties()->count() >= 4) {
            return redirect()->route('advertenties.index')
                ->withErrors(['Je mag maximaal 4 advertenties aanmaken.']);
        }

        $validated = $request->validate([
            'titel' => 'required|string|max:255',
            'beschrijving' => 'required|string',
            'prijs' => 'required|numeric|min:0',
        ]);

        $advertentie = Auth::user()->advertenties()->create($validated);

        // ✅ QR-code correct opbouwen (v5-stijl)
        $qrCode = (new QrCode(route('advertenties.show', $advertentie->id)));

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $filename = 'qrcodes/' . Str::uuid() . '.png';
        $path = storage_path('app/public/' . $filename);
        $result->saveToFile($path);

        $advertentie->qr_code = 'storage/' . $filename;
        $advertentie->save();

        return redirect()->route('advertenties.index')->with('success', 'Advertentie geplaatst!');
    }
    public function show($id)
    {
        $advertentie = Advertentie::with('favorieten')->findOrFail($id);
        $isFavoriet = $advertentie->favorieten->contains('user_id', Auth::id());
        return view('advertenties.show', compact('advertentie', 'isFavoriet'));
    }

    public function edit($id)
    {
        $advertentie = Advertentie::findOrFail($id);

        return view('advertenties.edit', compact('advertentie'));
    }

    public function update(Request $request, Advertentie $advertentie)
    {
        $validated = $request->validate([
            'titel' => 'required|string|max:255',
            'beschrijving' => 'required|string',
            'prijs' => 'required|numeric|min:0',
        ]);

        $advertentie->update($validated);

        return redirect()->route('advertenties.show', $advertentie)->with('success', 'Advertentie bijgewerkt!');
    }

    public function destroy(Advertentie $advertentie)
    {
        $this->authorize('delete', $advertentie);

        $advertentie->delete();

        return redirect()->route('advertenties.index')->with('success', 'Advertentie verwijderd.');
    }
}
