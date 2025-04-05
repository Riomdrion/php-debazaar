<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">📢 {{ __('adverts.advertentie') }}</h1>

            <div>
                @if (auth()->user()->role != 'gebruiker')
                    <a href="{{ route('advertenties.csvimport.create', ['type' => 'advertenties']) }}"
                       class="inline-block px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                        ➕ {{ __('adverts.importeer_advertenties') }}
                    </a>
                    <a href="{{ route('advertenties.create') }}"
                       class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        ➕ {{ __('adverts.advertentie_aanmaken') }}
                    </a>
                @endif
            </div>
        </div>

        <form method="GET" class="w-full md:w-1/3">
            <input type="text" name="zoek" value="{{ request('zoek') }}"
                   placeholder="🔍 {{ __('adverts.Zoek_op_titel') }}..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400">
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($advertenties as $advertentie)
                <div class="bg-white border border-gray-200 rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-5 flex flex-col justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $advertentie->titel }}</h2>
                        <p class="text-gray-600 text-sm">{{ Str::limit($advertentie->beschrijving, 100) }}</p>
                    </div>

                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-green-600 font-bold text-lg">&euro; {{ number_format($advertentie->prijs, 2, ',', '.') }}</span>
                        <a href="{{ route('advertenties.show', $advertentie->id) }}"
                           class="text-blue-600 font-medium hover:underline">
                            👉 {{ __('adverts.bekijk') }}
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 mt-8">
                    {{ __('adverts.Geen_advertenties_gevonden') }}.
                </div>
            @endforelse
        </div>
        <div class="mt-8">
            {{ $advertenties->links() }}
        </div>
    </div>
</x-app-layout>
