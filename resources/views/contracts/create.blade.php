<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('contracts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="bedrijf_id" value="{{ $bedrijf->id }}">
                <input type="hidden" name="is_goedgekeurd" value="0">

                <!-- Titel -->
                <div>
                    <label for="titel" class="block text-sm font-medium text-gray-700">Titel</label>
                    <input type="text" name="titel" id="titel" required
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>

                <!-- Prijs -->
                <div>
                    <label for="prijs" class="block text-sm font-medium text-gray-700">Prijs</label>
                    <input type="number" step="0.01" name="prijs" id="prijs" required
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>

                <!-- Factuur -->
                <div>
                    <label for="factuur" class="block text-sm font-medium text-gray-700">Factuur (PDF)</label>
                    <input type="file" name="factuur" id="factuur" accept=".pdf" required
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Maak Contract
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
