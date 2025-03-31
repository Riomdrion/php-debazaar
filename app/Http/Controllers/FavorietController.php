<?php

namespace App\Http\Controllers;

use App\Models\Advertentie;
use App\Models\Favoriet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class FavorietController extends Controller
{
    public function store(Advertentie $advertentie): RedirectResponse
    {
        Favoriet::firstOrCreate([
            'user_id' => Auth::id(),
            'advertentie_id' => $advertentie->id,
        ]);

        return back()->with('success', 'Advertentie toegevoegd aan favorieten.');
    }
}
