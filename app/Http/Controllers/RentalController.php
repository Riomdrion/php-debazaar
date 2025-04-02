<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\AgendaItem;
use App\Models\User;
use App\Models\VerhuurAdvertentie;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RentalController extends Controller
{
    public function create($verhuurAdvertentieid, $agendaItemid)
    {
        $agendaItem = AgendaItem::findOrFail($agendaItemid);
        $verhuurAdvertentie = VerhuurAdvertentie::findOrFail($verhuurAdvertentieid);

        // Haal de ingelogde gebruiker op)
        $user = Auth::user();


        return view('rentals.create', compact('agendaItem', 'user', 'verhuurAdvertentie'));
    }


    // Inlevering opslaan
    public function store(Request $request)
    {
        $request->validate([
            'agenda_item_id' => 'required|exists:agenda_items,id',
            'retour_foto' => 'required|image',
        ]);

        $agendaItem = AgendaItem::findOrFail($request->agenda_item_id);
        $verhuurAdvertentie = $agendaItem->verhuurAdvertentie;

        $fotoPath = $request->file('retour_foto')->store('retour_fotos', 'public');

        // --- Slijtage berekenen ---
        $start = Carbon::parse($agendaItem->start);
        $eind = Carbon::parse($agendaItem->eind);
        $dagen = $start->diffInDays($eind);

        $wear = $verhuurAdvertentie->wearSetting;
        $slijtage = 0;

        if ($wear && $verhuurAdvertentie->vervangingswaarde) {
            $slijtagePercentage = ($dagen * $wear->slijtage_per_dag) + $wear->slijtage_per_verhuur;
            $slijtagePercentage *= $wear->categorie_modifier;

            $slijtage = ($verhuurAdvertentie->vervangingswaarde * $slijtagePercentage) / 100;
        }

        $rental = Rental::create([
            'agenda_item_id' => $agendaItem->id,
            'retour_foto' => $fotoPath,
            'slijtage_kosten' => $slijtage,
        ]);

        return redirect()->route('rental.show', $rental)->with('success', 'Product succesvol ingeleverd!');
    }


    // Inlevering tonen
    public function show(Rental $rental)
    {
        // Haal de geconnecte agenda op
        $agendaItem = AgendaItem::findOrFail($rental->agenda_item_id);
        return view('rentals.show', compact('rental', 'agendaItem'));
    }
}
