<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use App\Models\Bedrijf;
use PDF;  // Zorg ervoor dat je een PDF-library zoals 'dompdf' hebt geïnstalleerd en gebruikt

class ContractController extends Controller
{
    public function create($bedrijf_id)
    {
        $bedrijf = Bedrijf::find($bedrijf_id);
        if (!$bedrijf) {
            return redirect()->route('admin.bedrijven.zonder.factuur')->with('error', 'Bedrijf niet gevonden.');
        }
        $contract = Contract::where('bedrijf_id', $bedrijf_id)->first();
        return view('contracts.create', compact('bedrijf', 'contract'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titel' => 'required|string',
            'bedrijf_id' => 'required|exists:bedrijfs,id',
            'factuur' => 'required|mimes:pdf|max:2048',
            'prijs' => 'required|numeric',
        ]);

        // Haal bedrijfsgegevens op
        $bedrijf = Bedrijf::findOrFail($request->bedrijf_id);

        // Alleen basiscontractgegevens opslaan
        $contract = new Contract();
        $contract->bedrijf_id = $request->bedrijf_id;
        $contract->is_goedgekeurd = 0;

        // Opslaan van het geüploade factuur PDF bestand
        if ($request->hasFile('factuur')) {
            $factuur = $request->file('factuur');
            $bestandsnaam = time() . '_' . $factuur->getClientOriginalName();
            $pad = $factuur->storeAs('public/contracts', $bestandsnaam);
            $contract->bestand = 'storage/contracts/' . $bestandsnaam;
        }

        $contract->save();

        // PDF Genereren met alle gegevens
        $data = [
            'bedrijf' => $bedrijf->naam,
            'titel' => $request->titel,
            'bestand' => $bestandsnaam ?? '',
            'prijs' => $request->prijs,
            'slug' => $bedrijf->slug,
            'huisstijl' => $bedrijf->huisstijl,
        ];

        $pdf = PDF::loadView('contracts.pdf', $data);
        $pdfPath = 'contracts/contract_' . $bedrijf->id . '_' . time() . '.pdf';
        $pdf->save(storage_path('app/public/' . $pdfPath));

        return redirect()->route('admin.bedrijven.zonder.factuur')
            ->with('success', 'Contract aangemaakt en PDF opgeslagen.');
    }
}
