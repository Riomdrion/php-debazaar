<x-app-layout>
    <!-- Display session errors, if any -->
    @if(session('error'))
        <div class="alert alert-danger mb-4" dusk="error-message">
            {{ session('error') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6" dusk="page-title">Bedrijven Zonder Factuur</h1>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200" dusk="bedrijven-table">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" dusk="table-header-bedrijf-naam">
                            Bedrijf Naam
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" dusk="table-header-acties">
                            Acties
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($bedrijven as $bedrijf)
                        <tr dusk="bedrijf-row">
                            <td class="px-6 py-4 whitespace-nowrap" dusk="bedrijf-naam-cell">
                                <div class="text-sm font-medium text-gray-900" dusk="bedrijf-naam">{{ $bedrijf->naam }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap" dusk="bedrijf-acties-cell">
                                <a href="{{ route('contracts.create', $bedrijf->id) }}" class="text-indigo-600 hover:text-indigo-900" dusk="maak-contract-link">Maak Contract</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
