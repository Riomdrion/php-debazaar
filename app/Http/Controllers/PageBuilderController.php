<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bedrijf;
use Illuminate\Support\Facades\DB;

class PageBuilderController extends Controller
{
    public function edit($slug)
    {
        $bedrijf = Bedrijf::where('slug', $slug)->firstOrFail();
        $components = $bedrijf->components()->orderBy('order')->get();
        return view('pagebuilder.edit', compact('bedrijf', 'components'));
    }

    public function update(Request $request, $slug)
    {
        $bedrijf = Bedrijf::where('slug', $slug)->firstOrFail();

        // Controleer of we überhaupt componenten ontvangen
        if (!$request->has('components') || !is_array($request->components)) {
            return redirect()->back()->with('error', 'Geen geldige componentdata ontvangen.');
        }

        DB::transaction(function () use ($request, $bedrijf) {
            $bedrijf->components()->delete();

            foreach ($request->components as $index => $compData) {
                $data = $compData['data']; // gebruik juiste variabele

                // Optioneel: check of het een array of string is, en decodeer indien nodig
                if (is_string($data)) {
                    $data = json_decode($data, true);

                    if (json_last_error() !== JSON_ERROR_NONE) {
                        throw new \Exception("Ongeldige JSON in component #{$index}.");
                    }
                }

                $bedrijf->components()->create([
                    'type' => $compData['type'],
                    'data' => $data,
                    'order' => $compData['order'] ?? 0,
                ]);
            }
        });

        return redirect()->back()->with('success', 'Landingpage is succesvol bijgewerkt.');
    }
}
