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

    public function update(Request $request)
    {
        $request->validate([
            'WinningBid' => 'required|numeric|min:1',
            'advertentie_id' => 'required|exists:advertenties,id',
            'bid_id' => 'required|exists:bids,id',
        ]);
        $advertentie = Advertentie::findOrFail($request->input('advertentie_id'));
        $bid = Bid::findorFail($request->input('bid_id'));

        $bid->WinningBid = $request->input('WinningBid');
        $bid->save();

        Advertentie::where('id', $advertentie->id)->update(['is_actief' => 0]);

        return redirect()->back()->with('success', 'Bod succesvol bijgewerkt!');
    }

    public function destroy($advertentieId)
    {
        $advertentie = Advertentie::findOrFail($advertentieId);

        $bid = Bid::where('advertentie_id', $advertentie->id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $bid->delete();

        return redirect()->back()->with('success', 'Bod succesvol verwijderd!');
    }
}
