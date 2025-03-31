<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavorietController extends Controller
{
    public function store(Request $request, Advertentie $advertentie)
    {
        Favoriet::firstOrCreate([
            'user_id' => Auth::id(),
            'advertentie_id' => $advertentie->id,
        ]);

        return back()->with('success', 'Advertentie toegevoegd aan favorieten.');
    }
}

