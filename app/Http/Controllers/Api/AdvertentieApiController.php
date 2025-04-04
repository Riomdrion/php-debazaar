<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VerhuurAdvertentie;
use Illuminate\Http\Request;
use App\Models\Advertentie;

class AdvertentieApiController extends Controller
{
    public function index()
    {
        // Haal alle advertenties op die aan de gebruiker zijn gekoppeld
        $advertenties = Advertentie::where('user_id', auth()->id())->get();
        $huuradvertenties = VerhuurAdvertentie::where('user_id', auth()->id())->get();
        return ['advertenties' => $advertenties, 'huuradvertenties' => $huuradvertenties];
    }
}

