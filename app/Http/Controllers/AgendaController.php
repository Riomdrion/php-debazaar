<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        $agendaItems = AgendaItem::where('user_id', Auth::id())
            ->orderBy('start_datum', 'asc')
            ->get();

        return view('agenda.index', compact('agendaItems'));
    }
}

