<?php

namespace App\Http\Controllers;

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
}
