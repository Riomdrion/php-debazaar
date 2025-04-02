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
            'advertentie_id' => 'nullable|exists:advertenties,id',
            'verhuur_advertentie_id' => 'nullable|exists:verhuur_advertenties,id',
        ]);

        $userId = Auth::id();
        $isFavoriet = $request->has('is_favoriet');

        if ($request->filled('advertentie_id')) {
            $advertentieId = $request->advertentie_id;

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
        } elseif ($request->filled('verhuur_advertentie_id')) {
            $verhuur_advertentie_id = $request->verhuur_advertentie_id;

            if ($isFavoriet) {
                Favoriet::firstOrCreate([
                    'user_id' => $userId,
                    'verhuur_advertentie_id' => $verhuur_advertentie_id,
                ]);
                $message = 'verhuuradvertentie toegevoegd aan favorieten.';
            } else {
                Favoriet::where('user_id', $userId)
                    ->where('verhuur_advertentie_id', $verhuur_advertentie_id)
                    ->delete();
                $message = 'verhuuradvertentie verwijderd uit favorieten.';
            }
        } else {
            return back()->withErrors(['error' => 'Geen geldige advertentie meegegeven.']);
        }

        return back()->with('success', $message);
    }
}
