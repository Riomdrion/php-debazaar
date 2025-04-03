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
        // Retrieve page numbers for each pagination type from query
        $normalPage = $request->input('normalPage', 1);
        $rentalPage = $request->input('rentalPage', 1);

        // Fetch paginated results with specified page numbers
        $recentNormalAds = Advertentie::latest()->paginate(4, ['*'], 'normalPage', $normalPage);
        $recentRentalAds = VerhuurAdvertentie::where('is_actief', 1)->latest()->paginate(4, ['*'], 'rentalPage', $rentalPage);

        return view('dashboard', compact('recentNormalAds', 'recentRentalAds'));
    }
}
