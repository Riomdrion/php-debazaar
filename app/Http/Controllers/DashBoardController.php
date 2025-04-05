<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use Illuminate\Http\Request;
use App\Models\Advertentie;
use App\Models\VerhuurAdvertentie;

class DashBoardController extends Controller
{
    /**
     * Display the most recent advertisements.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $zoekTerm = $request->input('zoek', '');
        $normalPage = $request->input('normalPage', 1);
        $rentalPage = $request->input('rentalPage', 1);

        $recentNormalAds = Advertentie::when($zoekTerm, function ($query, $zoekTerm) {
            return $query->where('titel', 'like', "%{$zoekTerm}%");
        })->latest()->paginate(4, ['*'], 'normalPage', $normalPage);

        $recentRentalAds = VerhuurAdvertentie::where('is_actief', 1)
            ->when($zoekTerm, function ($query, $zoekTerm) {
                return $query->where('titel', 'like', "%{$zoekTerm}%");
            })->latest()->paginate(4, ['*'], 'rentalPage', $rentalPage);

        return view('dashboard', compact('recentNormalAds', 'recentRentalAds', 'normalPage', 'rentalPage'));
    }

    public function index2(Request $request)
    {
        $zoekTerm = $request->input('zoek', '');
        $normalPage = $request->input('normalPage', 1);
        $rentalPage = $request->input('rentalPage', 1);
        $user = auth()->user();

        // Laatste advertenties
        $recentNormalAds = Advertentie::when($zoekTerm, function ($query, $zoekTerm) {
            return $query->where('titel', 'like', "%{$zoekTerm}%");
        })->latest()->paginate(4, ['*'], 'normalPage', $normalPage);

        $recentRentalAds = VerhuurAdvertentie::where('is_actief', 1)
            ->when($zoekTerm, function ($query, $zoekTerm) {
                return $query->where('titel', 'like', "%{$zoekTerm}%");
            })->latest()->paginate(4, ['*'], 'rentalPage', $rentalPage);

        // Gekochte items
        $gewonnenBiedingen = Bid::with('advertentie')
            ->where('user_id', $user->id)
            ->where('WinningBid', true)
            ->get();

        // Favorieten
        $favorieteAdvertenties = Advertentie::whereIn('id', function ($query) use ($user) {
            $query->select('advertentie_id')
                ->from('favorites')
                ->where('user_id', $user->id)
                ->whereNotNull('advertentie_id');
        })->get();

        $favorieteVerhuur = VerhuurAdvertentie::whereIn('id', function ($query) use ($user) {
            $query->select('verhuur_advertentie_id')
                ->from('favorites')
                ->where('user_id', $user->id)
                ->whereNotNull('verhuur_advertentie_id');
        })->get();

        return view('mydashboard', compact(
            'recentNormalAds',
            'recentRentalAds',
            'normalPage',
            'rentalPage',
            'gewonnenBiedingen',
            'favorieteAdvertenties',
            'favorieteVerhuur'
        ));
    }
}
