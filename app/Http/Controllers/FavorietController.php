<?php

namespace App\Http\Controllers;

use App\Models\Favoriet;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class FavorietController extends Controller
{
    public function toggle(Request $request): RedirectResponse
    {
        $request->validate([
            'advertentie_id' => 'required|exists:advertenties,id',
        ]);

        $advertentieId = $request->advertentie_id;
        $userId = Auth::id();
        $isFavoriet = $request->has('is_favoriet');

        if ($isFavoriet) {
            Favoriet::firstOrCreate([
                'user_id' => $userId,
                'advertentie_id' => $advertentieId,
            ]);
            $message = 'Advertentie toegevoegd aan favorieten.';
        } else {
            Favoriet::where('user_id', $userId)
                ->where('advertentie_id', $advertentieId)
                ->delete();
            $message = 'Advertentie verwijderd uit favorieten.';
        }

        return back()->with('success', $message);
    }


}
