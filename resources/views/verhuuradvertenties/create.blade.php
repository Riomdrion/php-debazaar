<x-app-layout>
    <div class="p-6 max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">📝 Nieuwe Verhuuradvertentie</h1>

            <form method="POST" action="{{ route('verhuuradvertenties.store') }}" class="space-y-6">
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
                    <label class="block text-gray-700 font-medium mb-1">Dagprijs (€)</label>
                    <input type="number" name="dagprijs" step="0.01"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Borg (€)</label>
                    <input type="number" name="borg" step="0.01"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Vervangingswaarde (€)</label>
                    <input type="number" name="vervangingswaarde" step="1.00"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                           required>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_actief" id="is_actief" value="1"
                           class="mr-2 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="is_actief" class="text-gray-700 font-medium">Actief</label>
                </div>


                <button type="submit"
                        class="w-full md:w-auto px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                    ✅ Plaatsen
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
