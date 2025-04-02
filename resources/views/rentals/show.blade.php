<x-app-layout>
    <div class="p-6 max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">📋 Inlevering bevestigd</h1>

            <div class="space-y-2 text-gray-700">
                <p><strong>Advertentie:</strong> {{ $agendaItem->verhuurAdvertentie->titel ?? 'Onbekend' }}</p>
                <p><strong>Gehuurd door:</strong> {{ $rental->agendaItem->user->name }}</p>
                <p><strong>Periode:</strong> {{ $rental->agendaItem->start->format('d-m-Y H:i') }} t/m {{ $rental->agendaItem->eind->format('d-m-Y H:i') }}</p>
                <p><strong>Slijtagekosten:</strong> €{{ number_format($rental->slijtage_kosten, 2, ',', '.') }}</p>
            </div>

            <div class="mt-6">
                <p class="font-medium text-gray-700 mb-2">🖼️ Foto bij inlevering:</p>
                <img src="{{ asset('storage/' . $rental->retour_foto) }}" alt="Retour foto"
                     class="rounded-lg border border-gray-300 shadow max-w-full">
            </div>
        </div>
    </div>
</x-app-layout>
