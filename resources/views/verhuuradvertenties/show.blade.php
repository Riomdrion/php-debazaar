<x-app-layout>
    <div class="p-6 max-w-2xl mx-auto space-y-6">
        <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6">
            <div class="flex space-x-6 justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $verhuurAdvertentie->titel }}</h1>
                    <p><strong>Beschrijving:</strong> {{ $verhuurAdvertentie->beschrijving }}</p>
                    <p><strong>Dagprijs:</strong> €{{ number_format($verhuurAdvertentie->dagprijs, 2) }}</p>
                    <p><strong>Borg:</strong> €{{ number_format($verhuurAdvertentie->borg, 2) }}</p>
                    <p><strong>Status:</strong><span class="{{ $verhuurAdvertentie->is_actief ? 'text-green-600' : 'text-red-600' }}">{{ $verhuurAdvertentie->is_actief ? 'Actief' : 'Inactief' }}</span></p>
                </div>
                <div>
                    @if ($verhuurAdvertentie->user && $verhuurAdvertentie->user->bedrijf)
                        <a href="{{ route('bedrijven.show', ['bedrijf' => $verhuurAdvertentie->user->bedrijf->id]) }}" class="text-blue-500 hover:underline">
                            Bekijk Bedrijfsreviews
                        </a>
                    @endif
                    @if ($verhuurAdvertentie->qr_code)
                        <img src="{{ asset($verhuurAdvertentie->qr_code) }}" alt="QR Code" class="w-48 h-48">
                    @endif
                </div>
            </div>

            @if (auth()->id() === $verhuurAdvertentie->user_id)
            <div class="mt-6 flex justify-between">
                <a href="{{ route('verhuuradvertenties.edit', $verhuurAdvertentie->id) }}"
                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                    ✏️ Bewerken
                </a>

                <form action="{{ route('verhuuradvertenties.destroy', $verhuurAdvertentie->id) }}" method="POST"
                      onsubmit="return confirm('Weet je zeker dat je deze advertentie wilt verwijderen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        🗑️ Verwijderen
                    </button>
                </form>
            </div>
            @endif
        </div>
            <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">⭐ Favoriet maken</h2>
                <form method="POST" action="{{ route('favorites.toggle') }}">
                    @csrf
                    <input type="hidden" name="advertentie_id" value="{{ $verhuurAdvertentie->id }}">
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="is_favoriet"
                               {{ $isFavoriet ? 'checked' : '' }} class="form-checkbox text-blue-600">
                        <label class="text-gray-700">Toevoegen aan favorieten</label>
                    </div>
                    <button type="submit"
                            class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        Opslaan
                    </button>
                </form>
            </div>

    </div>
</x-app-layout>
