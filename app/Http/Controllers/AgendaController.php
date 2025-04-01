<?php

namespace App\Http\Controllers;

use App\Models\AgendaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    public function index()
    {
        $agendaItems = AgendaItem::where('user_id', Auth::id())
            ->orderBy('start_datum', 'asc')
            ->get();

        return view('agenda.index', compact('agendaItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'verhuur_advertentie_id' => 'required|exists:verhuur_advertenties,id',
            'titel' => 'required|string|max:255',
            'start' => 'required|date|before:eind',
            'eind' => 'required|date|after:start',
            'type' => 'required|in:verhuur,gehuurd',
        ]);

        AgendaItem::create([
            'user_id' => auth()->id(),
            'verhuur_advertentie_id' => $request->verhuur_advertentie_id,
            'titel' => $request->titel,
            'start' => $request->start,
            'eind' => $request->eind,
            'type' => $request->type,
        ]);

        return back()->with('success', 'Agenda-item toegevoegd!');
    }

}

