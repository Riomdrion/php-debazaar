<?php
namespace App\Http\Controllers;

use App\Models\Advertentie;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Advertentie $advertentie)
    {
        $validated = $request->validate([
            'tekst' => 'required|string',
            'score' => 'required|integer|min:1|max:5',
        ]);

        $review = new Review($validated);
        $review->user_id = Auth::id();
        $review->advertentie_id = $advertentie->id;
        $review->save();

        return back()->with('success', 'Review geplaatst.');
    }
}


