<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertentie;
use Illuminate\Http\Request;

class AdvertentieApiController extends Controller
{
    public function index()
    {
        return Advertentie::where('user_id', auth()->id())->get();
    }

    public function show($id)
    {
        $advertentie = Advertentie::where('user_id', auth()->id())->findOrFail($id);
        return response()->json($advertentie);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titel' => 'required|string|max:255',
            'beschrijving' => 'required|string',
            'prijs' => 'required|numeric',
        ]);

        $advertentie = Advertentie::create(array_merge($validated, ['user_id' => auth()->id()]));

        return response()->json($advertentie, 201);
    }

    public function update(Request $request, $id)
    {
        $advertentie = Advertentie::where('user_id', auth()->id())->findOrFail($id);

        $advertentie->update($request->only(['titel', 'beschrijving', 'prijs']));

        return response()->json($advertentie);
    }

    public function destroy($id)
    {
        $advertentie = Advertentie::where('user_id', auth()->id())->findOrFail($id);
        $advertentie->delete();

        return response()->json(null, 204);
    }
}
