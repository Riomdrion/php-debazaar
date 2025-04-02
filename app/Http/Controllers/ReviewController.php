<?php
namespace App\Http\Controllers;

use App\Models\Advertentie;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tekst' => 'required|string|max:1000',  // Ensuring validation on text
            'score' => 'required|integer|min:1|max:5',
            'advertentie_id' => 'nullable|integer', // Allowing null values
            'bedrijf_id' => 'nullable|integer',      // Allowing null values
            'verhuur_advertentie_id' => 'nullable|integer', // Allowing null values
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'advertentie_id' => $validated['advertentie_id'] ?? null,
            'bedrijf_id' => $validated['bedrijf_id'] ?? null,
            'verhuur_advertentie_id' => $validated['verhuur_advertentie_id'] ?? null,
            'bericht' => $validated['tekst'],
            'rating' => $validated['score'],
        ]);

        return back()->with('success', 'Review geplaatst.');
    }
}


