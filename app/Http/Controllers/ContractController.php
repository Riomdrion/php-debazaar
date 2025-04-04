<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use App\Models\Bedrijf;
class ContractController
{
    // In ContractController
    public function create($bedrijf_id)
    {
        $bedrijf = Bedrijf::find($bedrijf_id);
        if (!$bedrijf) {
            return redirect()->route('admin.bedrijven.zonder.factuur')->with('error', 'Bedrijf niet gevonden.');
        }
        return view('contracts.create', compact('bedrijf'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titel' => 'required|string',
            'bedrijf_id' => 'required|exists:bedrijfs,id',
            'factuur' => 'required|mimes:pdf|max:2048',
        ]);

        // Je logica voor het maken van de PDF en opslag
        // Zorg ervoor dat je het contract opslaat met is_goedgekeurd op 0
        // bijv:
        $contract = new Contract();
        $contract->bedrijf_id = $request->bedrijf_id;
        // Opslaan van andere contract details en bestand...
        $contract->is_goedgekeurd = 0; // Zorg dat het begin niet-goedgekeurd is
        $contract->save();

        return redirect()->route('admin.bedrijven.zonder.factuur')->with('success', 'Contract aangemaakt.');
    }
}
