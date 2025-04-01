<x-app-layout>
    <div class="p-6 max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $verhuurAdvertentie->titel }}</h1>

            <div class="space-y-4 text-gray-700">
                <p><strong>Beschrijving:</strong> {{ $verhuurAdvertentie->beschrijving }}</p>
                <p><strong>Dagprijs:</strong> €{{ number_format($verhuurAdvertentie->dagprijs, 2) }}</p>
                <p><strong>Borg:</strong> €{{ number_format($verhuurAdvertentie->borg, 2) }}</p>
                <p><strong>Status:</strong>
                    <span class="{{ $verhuurAdvertentie->is_actief ? 'text-green-600' : 'text-red-600' }}">
                        {{ $verhuurAdvertentie->is_actief ? 'Actief' : 'Inactief' }}
                    </span>
                </p>
            </div>

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
        </div>
    </div>
</x-app-layout>
