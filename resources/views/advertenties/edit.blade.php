<x-app-layout>
    <div class="p-6 max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">✏️ {{ __('adverts.Bewerken') }}: {{ $advertentie->titel }}</h1>

            <form method="POST" action="{{ route('advertenties.update', $advertentie) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-gray-700 font-medium mb-1">{{ __('adverts.titel') }}</label>
                    <input type="text" name="titel" value="{{ old('titel', $advertentie->titel) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">{{ __('adverts.beschrijving') }}</label>
                    <textarea name="beschrijving" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                              required>{{ old('beschrijving', $advertentie->beschrijving) }}</textarea>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">{{ __('adverts.prijs') }}</label>
                    <input type="number" name="prijs" step="0.01" value="{{ old('prijs', $advertentie->prijs) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                           required>
                </div>
                <hr class="my-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_actief" id="is_actief" value="1"
                           class="mr-2 h-4 w-4 text-blue-600 border-gray-300 rounded"
                        {{ old('is_actief', $advertentie->is_actief) ? 'checked' : '' }}>
                    <label for="is_actief" class="text-gray-700 font-medium">{{ __('adverts.actief') }}</label>
                </div>

                <button type="submit" dusk="advertentie-bewerken-knop"
                        class="w-full md:w-auto px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    💾 {{ __('adverts.opslaan') }}
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
