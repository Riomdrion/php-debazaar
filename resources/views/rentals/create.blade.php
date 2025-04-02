@php use Carbon\Carbon; @endphp
<x-app-layout>
    <div class="p-6 max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">📦 Product inleveren</h1>
            <div class="mb-4">

                <p><strong>Advertentie:</strong> {{ $verhuurAdvertentie->titel}} {{ $agendaItem->id }}</p>
                <p><strong>Periode:</strong> {{ Carbon::parse($agendaItem->start)->format('d-m-Y H:i') }} t/m {{ Carbon::parse($agendaItem->eind)->format('d-m-Y H:i') }}</p>
                <p><strong>Gehuurd door:</strong> {{$user->name ?? 'Onbekend' }}</p>
            </div>

            <form method="POST" action="{{ route('rentals.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <input type="hidden" name="agenda_item_id" value="{{ $agendaItem->id }}">

                <div>
                    <label class="block text-gray-700 font-medium mb-1">📷 Upload foto bij inlevering</label>
                    <input type="file" name="retour_foto"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                           required>
                </div>

                <button type="submit"
                        class="w-full md:w-auto px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    ✅ Inleveren
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
