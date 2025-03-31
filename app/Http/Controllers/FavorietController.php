<?php

namespace App\Http\Controllers;

use App\Models\Favoriet;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class FavorietController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'advertentie_id' => 'required|exists:advertenties,id',
        ]);

        Favoriet::firstOrCreate([
            'user_id' => Auth::id(),
            'advertentie_id' => $request->advertentie_id,
        ]);

        return back()->with('success', 'Advertentie toegevoegd aan favorieten.');
    }

    public function destroy($id): RedirectResponse
    {
        $favoriet = Favoriet::where('user_id', Auth::id())
            ->where('advertentie_id', $id)
            ->first();

        if ($favoriet) {
            $favoriet->delete();
            return back()->with('success', 'Advertentie verwijderd uit favorieten.');
        }

        return back()->withErrors(['Advertentie niet gevonden in favorieten.']);
    }

}
