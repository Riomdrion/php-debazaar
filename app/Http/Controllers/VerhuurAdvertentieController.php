<?php

namespace App\Http\Controllers;

use App\Models\Advertentie;
use App\Models\VerhuurAdvertentie;
use App\Models\AdvertentieKoppeling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

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
            'is_actief' => 'boolean'
        ]);

        $verhuurAdvertentie = new VerhuurAdvertentie($validated);
        $verhuurAdvertentie->user_id = Auth::id();
        $verhuurAdvertentie->is_actief = $request->has('is_actief');
        $verhuurAdvertentie->save();

        return redirect()->route('verhuuradvertenties.index')->with('success', 'Verhuuradvertentie geplaatst!');
    }

    public function show(VerhuurAdvertentie $verhuurAdvertentie)
    {
        return view('verhuuradvertenties.show', compact('verhuurAdvertentie'));
    }

    public function edit(VerhuurAdvertentie $verhuurAdvertentie)
    {
        $andereAdvertenties = Auth::user()->advertenties;
        return view('verhuuradvertenties.edit', compact('verhuurAdvertentie', 'andereAdvertenties'));
    }

    public function update(Request $request, VerhuurAdvertentie $verhuurAdvertentie)
    {
        $validated = $request->validate([
            'titel' => 'required|string|max:255',
            'beschrijving' => 'required|string',
            'dagprijs' => 'required|numeric|min:0',
            'borg' => 'required|numeric|min:0',
            'is_actief' => 'boolean',
            'koppelingen' => 'array',
            'koppelingen.*' => 'exists:advertenties,id',
        ]);

        $verhuurAdvertentie->update($validated);
        $verhuurAdvertentie->is_actief = $request->has('is_actief');
        $verhuurAdvertentie->save();

        AdvertentieKoppeling::where('advertentie_id', $verhuurAdvertentie->id)->delete();

        if (!empty($validated['koppelingen'])) {
            foreach ($validated['koppelingen'] as $gekoppeldId) {
                AdvertentieKoppeling::create([
                    'advertentie_id' => $verhuurAdvertentie->id,
                    'gekoppeld_id' => $gekoppeldId,
                ]);
            }
        }

        return redirect()->route('verhuuradvertenties.index')->with('success', 'Verhuuradvertentie bijgewerkt!');
    }

    public function destroy(VerhuurAdvertentie $verhuurAdvertentie)
    {
        $verhuurAdvertentie->delete();
        return redirect()->route('verhuuradvertenties.index')->with('success', 'Advertentie verwijderd.');
    }
}
