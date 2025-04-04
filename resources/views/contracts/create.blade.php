<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Nieuw Contract voor {{ $bedrijf->naam }}</h1>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                <form action="{{ route('contracts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="bedrijf_id" value="{{ $bedrijf->id }}">

                    <div>
                        <label for="titel" class="block text-sm font-medium text-gray-700">Titel</label>
                        <div class="mt-1">
                            <input type="text" name="titel" id="titel" required
                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div>
                        <label for="factuur" class="block text-sm font-medium text-gray-700">Factuur (PDF)</label>
                        <div class="mt-1">
                            <input type="file" name="factuur" id="factuur" accept=".pdf" required
                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
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
    </div>
</x-app-layout>
