<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto space-y-6">

        @if (auth()->id() === $advertentie->user_id)
            <div class="flex justify-end">
                <a href="{{ route('advertenties.edit', $advertentie->id) }}" class="text-blue-600 hover:underline font-medium">
                    ✏️ Bewerken
                </a>
            </div>
        @endif

            <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200 flex space-x-6 justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $advertentie->titel }}</h1>
                    <p class="text-gray-600 mt-4">{{ $advertentie->beschrijving }}</p>
                    <p class="text-xl font-semibold text-green-600 mt-4">
                        &euro; {{ number_format($advertentie->prijs, 2, ',', '.') }}</p>
                </div>
                <div>
                    @if ($advertentie->qr_code)
                        <img src="{{ asset($advertentie->qr_code) }}" alt="QR Code" class="w-48 h-48">
                    @endif
                </div>
            </div>

            @if ($advertentie->gekoppeldeAdvertenties->isNotEmpty())
                <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Gekoppelde advertenties</h3>
                    <ul class="list-disc ml-6 space-y-2">
                        @foreach ($advertentie->gekoppeldeAdvertenties as $gekoppeld)
                            <li>
                                <a href="{{ route('advertenties.show', $gekoppeld->id) }}"
                                   class="text-blue-500 hover:underline">
                                    {{ $gekoppeld->titel }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">⭐ Favoriet maken</h2>
            <form method="POST" action="{{ route('favorites.toggle') }}">
                @csrf
                <input type="hidden" name="advertentie_id" value="{{ $advertentie->id }}">

                <div class="flex items-center space-x-2">
                    <input type="checkbox" name="is_favoriet" {{ $isFavoriet ? 'checked' : '' }} class="form-checkbox text-blue-600">
                    <label class="text-gray-700">Toevoegen aan favorieten</label>
                </div>

                <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Opslaan
                </button>
            </form>
        </div>

        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">📝 Review plaatsen</h2>
            <form method="POST" action="{{ route('reviews.store', ['advertentie' => $advertentie->id]) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Review</label>
                    <textarea name="tekst" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" rows="3" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Score (1 t/m 5)</label>
                    <input type="number" name="score" min="1" max="5" class="w-20 border border-gray-300 rounded-lg px-2 py-1 focus:outline-none focus:ring focus:border-blue-300" required>
                </div>

                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    Plaatsen
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
