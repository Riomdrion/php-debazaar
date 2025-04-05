<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Contracten ter Goedkeuring</h2>
                @if($contracts->count() > 0)
                    <div class="space-y-4">
                        @foreach($contracts as $contract)
                            <div class="border p-4 rounded">
                                <h3 class="text-lg font-semibold">
                                    Contract voor {{ $contract->bedrijf->naam }}
                                </h3>
                                <div class="mt-2">
                                    <embed src="{{ asset($contract->bestand) }}"
                                           type="application/pdf"
                                           width="100%"
                                           height="400px" />
                                </div>
                                <form action="{{ route('contracts.approve', $contract->id) }}" method="POST" class="mt-4">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Goedkeuren
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>Geen contracten wachten op goedkeuring.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
