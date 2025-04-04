<?php

namespace App\Http\Controllers;

use App\Models\Bedrijf;
use Illuminate\Http\Request;

class BedrijfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Haal alle bedrijven op
        $bedrijven = Bedrijf::all();
        return view('bedrijven.index', compact('bedrijven'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valideer en sla een nieuw bedrijf op
        $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'beschrijving' => 'nullable|string',
            // Voeg andere velden toe die je nodig hebt
        ]);

        Bedrijf::create($validated);

        return redirect()->route('bedrijven.index')
            ->with('success', 'Bedrijf succesvol aangemaakt.');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $bedrijf = Bedrijf::where('slug', $slug)->firstOrFail();
        return view('bedrijf.show', compact('bedrijf'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bedrijf = Bedrijf::findOrFail($id);
        return view('bedrijf.edit', compact('bedrijf'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Ophalen via ID
        $bedrijf = Bedrijf::findOrFail($request->input('id'));

        $request->validate([
            'naam' => 'required|string',
            'slug' => 'required|string|unique:bedrijfs,slug,' . $bedrijf->id,
            'huisstijl' => 'nullable|string',
        ]);

        $bedrijf->update($request->all());

        return redirect()->back()->with('success', 'Bedrijfsinstellingen zijn bijgewerkt.');
    }
}
