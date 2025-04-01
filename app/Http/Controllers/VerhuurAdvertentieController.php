<?php

namespace App\Http\Controllers;

use App\Models\VerhuurAdvertentie;
use App\Models\AdvertentieKoppeling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function show($id)
    {
        $verhuurAdvertentie = VerhuurAdvertentie::findOrFail($id);
        return view('verhuuradvertenties.show', compact('verhuurAdvertentie', ));
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
            'is_actief' => 'boolean',
            'koppelingen' => 'array',
            'koppelingen.*' => 'exists:advertenties,id',
        ]);

        $verhuurAdvertentie = new VerhuurAdvertentie($validated);
        $verhuurAdvertentie->user_id = auth()->id(); // ✅ verplicht veld zetten
        $verhuurAdvertentie->is_actief = $request->has('is_actief');
        $verhuurAdvertentie->save();


        // Koppelingen updaten
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
