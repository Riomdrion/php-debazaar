<?php

namespace App\Http\Controllers;

use App\Models\Bedrijf;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function show($slug)
    {
        $bedrijf = Bedrijf::where('slug', $slug)->firstOrFail();
        $components = $bedrijf->components()->orderBy('order')->get();

        return view('bedrijf.landingpage', compact('bedrijf', 'components'));
    }
}
