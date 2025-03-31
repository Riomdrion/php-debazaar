<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerhuurAdvertentieController extends Controller
{
    public function create()
    {
        if (Auth::user()->verhuurAdvertenties()->count() >= 4) {
            return back()->withErrors(['Je mag maximaal 4 verhuuradvertenties aanmaken.']);
        }

        return view('verhuur.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->verhuurAdvertenties()->count() >= 4) {
            return back()->withErrors(['Je mag maximaal 4 verhuuradvertenties aanmaken.']);
        }

        $validated = $request->validate([
            'advertentie_id' => 'required|exists:advertenties,id',
            'start_datum' => 'required|date',
            'eind_datum' => 'required|date|after:start_datum',
        ]);

        Auth::user()->verhuurAdvertenties()->create($validated);

        return redirect()->route('advertenties.index')->with('success', 'Verhuuradvertentie geplaatst.');
    }
}
