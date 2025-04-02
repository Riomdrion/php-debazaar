<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\AgendaItem;
use App\Models\User;
use App\Models\VerhuurAdvertentie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RentalController extends Controller
{
    public function create(AgendaItem $agendaItem,VerhuurAdvertentie $verhuurAdvertentie)
    {
        $user = Auth::user();

        return view('rentals.create', compact('agendaItem', 'user', 'verhuurAdvertentie'));
    }


    // Inlevering opslaan
    public function store(Request $request)
    {
        $request->validate([
            'agenda_item_id' => 'required|exists:agenda_items,id',
            'retour_foto' => 'required|image|max:2048',
        ]);

        $agendaItem = AgendaItem::findOrFail($request->agenda_item_id);

        // Foto opslaan
        $path = $request->file('retour_foto')->store('rentals', 'public');

        // Placeholder voor slijtageberekening
        $slijtageKosten = rand(5, 25); // tijdelijk random bedrag

        $rental = Rental::create([
            'agenda_item_id' => $agendaItem->id,
            'slijtage_kosten' => $slijtageKosten,
            'retour_foto' => $path,
        ]);

        return redirect()->route('rentals.show', $rental);
    }

    // Inlevering tonen
    public function show(Rental $rental)
    {
        return view('rentals.show', compact('rental'));
    }
}
