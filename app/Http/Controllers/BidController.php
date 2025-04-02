<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Advertentie;
use Illuminate\Http\Request;

class BidController extends Controller
{
    public function store(Request $request, $advertentieId)
    {
        $advertentie = Advertentie::findOrFail($advertentieId);

        // Controleer of er al 4 biedingen zijn
        if ($advertentie->bids()->count() >= 4) {
            return redirect()->back()->with('error', 'Er mogen maximaal 4 biedingen per advertentie worden geplaatst.');
        }

        $request->validate([
            'bedrag' => 'required|numeric|min:0.01',
        ]);

        $bid = new Bid([
            'bedrag' => $request->input('bedrag'),
            'user_id' => auth()->id(),
            'advertentie_id' => $advertentie->id,
        ]);

        $advertentie->bids()->save($bid);

        return redirect()->back()->with('success', 'Bod succesvol geplaatst!');
    }
}
