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
    public function show($id)
    {
        $contract = Contract::findOrFail($id);

        // Volledig pad naar het PDF-bestand
        $fullPath = storage_path('app/public/' . $contract->bestand);

        // Controleer of het bestand bestaat
        if (!file_exists($fullPath)) {
            abort(404, 'Bestand niet gevonden');
        }

        // Stuur het bestand als download of inline weergave
        return response()->file($fullPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="contract.pdf"'
        ]);
    }
    public function approve($id)
    {
        $contract = Contract::findOrFail($id);

        // Zet is_goedgekeurd op 1
        $contract->is_goedgekeurd = 1;
        $contract->save();

        return redirect()->back()->with('success', 'Contract is goedgekeurd');
    }
    // In je ContractController
    public function goedkeuren()
    {
        // Haal het bedrijf op van de ingelogde gebruiker
        $bedrijf = auth()->user()->bedrijf;

        // Als de gebruiker geen bedrijf heeft, return een lege collectie of een foutmelding
        if (!$bedrijf) {
            return view('contracts.goedkeuren', ['contracts' => collect()]);
        }

        // Haal alleen de niet-goedgekeurde contracten op voor het bedrijf van de ingelogde gebruiker
        $contracts = Contract::where('bedrijf_id', $bedrijf->id)
            ->where('is_goedgekeurd', 0)
            ->with('bedrijf')
            ->get();

        return view('contracts.goedkeuren', compact('contracts'));
    }
}
