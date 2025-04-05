<x-app-layout>
    <div class="p-6 max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">✏️ {{ __('adverts.Verhuuradvertentie_bewerken') }}</h1>
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
                    <strong>Er zijn fouten opgetreden:</strong>
                    <ul class="list-disc list-inside mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('verhuuradvertenties.update', $verhuurAdvertentie) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-gray-700 font-medium mb-1">{{ __('adverts.Titel') }}</label>
                    <input type="text" name="titel"
                           value="{{ old('titel', $verhuurAdvertentie->titel) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">{{ __('adverts.Beschrijving') }}</label>
                    <textarea name="beschrijving" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                              required>{{ old('beschrijving', $verhuurAdvertentie->beschrijving) }}</textarea>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">{{ __('adverts.Dagprijs') }} (€)</label>
                    <input type="number" name="dagprijs" step="0.01"
                           value="{{ old('dagprijs', $verhuurAdvertentie->dagprijs) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">{{ __('adverts.Borg') }} (€)</label>
                    <input type="number" name="borg" step="0.01"
                           value="{{ old('borg', $verhuurAdvertentie->borg) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                           required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">{{ __('adverts.Vervangingswaarde') }} (€)</label>
                    <input type="number" name="vervangingswaarde" step="1.00"
                            value="{{ old('vervangingswaarde', $verhuurAdvertentie->vervangingswaarde) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                           required>
                </div>
                <hr class="my-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">{{ __('adverts.Slijtage_per_dag') }} (€)</label>
                    <input type="number" name="slijtage_per_dag" step="0.01"
                           value="{{ old('slijtage_per_dag', $slijtage->slijtage_per_dag) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">{{ __('adverts.Slijtage_per_verhuur') }} (€)</label>
                    <input type="number" name="slijtage_per_verhuur" step="0.01"
                           value="{{ old('slijtage_per_verhuur', $slijtage->slijtage_per_verhuur) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                           required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">{{ __('adverts.Categorie_modifier') }}</label>
                    <input type="number" name="categorie_modifier" step="0.01"
                           value="{{ old('categorie_modifier', $slijtage->categorie_modifier) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400"
                           required>
                </div>
                <hr class="my-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_actief" id="is_actief" value="1"
                           class="mr-2 h-4 w-4 text-blue-600 border-gray-300 rounded"
                        {{ old('is_actief', $verhuurAdvertentie->is_actief) ? 'checked' : '' }}>
                    <label for="is_actief" class="text-gray-700 font-medium">{{ __('adverts.actief') }}</label>
                </div>
                <button type="submit"
                        class="w-full md:w-auto px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    💾 {{ __('adverts.opslaan') }}
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
