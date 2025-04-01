<x-app-layout>
    <div class="p-6 max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">📝 Nieuwe Advertentie</h1>

            <form method="POST" action="{{ route('advertenties.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Titel</label>
                    <input type="text" name="titel"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Beschrijving</label>
                    <textarea name="beschrijving" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                              required></textarea>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Prijs</label>
                    <input type="number" name="prijs" step="0.01"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Koppel andere advertenties</label>
                    <select name="koppelingen[]" multiple
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400">
                        @foreach ($alleAdvertenties as $optie)
                            <option value="{{ $optie->id }}">{{ $optie->titel }}</option>
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Houd <kbd>Ctrl</kbd> of <kbd>Cmd</kbd> ingedrukt om meerdere te selecteren.</p>
                </div>

                <button type="submit"
                        class="w-full md:w-auto px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                    ✅ Plaatsen
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
