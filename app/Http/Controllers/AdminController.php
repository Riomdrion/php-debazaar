<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bedrijf; // Vergeet niet om het Bedrijf model te importeren
class AdminController extends Controller
{
    public function bedrijvenZonderFactuur()
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Je hebt geen toegang tot deze pagina.');
        }

        $bedrijven = Bedrijf::doesntHave('contracts')->get();
        return view('admin.bedrijven_zonder_factuur', compact('bedrijven'));
    }
}
