<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 max-w-7xl mx-auto ">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">📢 mijn dashboard</h1>

                {{-- Gewonnen biedingen --}}
                <h2 class="text-2xl font-bold text-gray-800 mt-12">🎯 Mijn Gekochte Items</h2>
                @forelse ($gewonnenBiedingen as $bod)
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 my-2 rounded-md shadow-sm  mb-4">
                        <p class="font-semibold">{{ $bod->advertentie->titel }}</p>
                        <p class="text-sm text-gray-600">Geboden bedrag: €{{ number_format($bod->bedrag, 2, ',', '.') }}</p>
                        <a href="{{ route('advertenties.show', $bod->advertentie->id) }}" class="text-blue-600 hover:underline text-sm">👉 Bekijk advertentie</a>
                    </div>
                @empty
                    <p class="text-gray-500 mb-4">Je hebt nog geen items gewonnen.</p>
                @endforelse

                {{-- Favoriete normale advertenties --}}
                <h2 class="text-2xl font-bold text-gray-800 mt-12">❤️ Mijn Favoriete Advertenties</h2>
                @forelse ($favorieteAdvertenties as $fav)
                    <div class="bg-white border border-gray-200 rounded-xl shadow p-4 my-2 mb-4">
                        <p class="font-semibold">{{ $fav->titel }}</p>
                        <a href="{{ route('advertenties.show', $fav->id) }}" class="text-blue-600 hover:underline text-sm">👉 Bekijk advertentie</a>
                    </div>
                @empty
                    <p class="text-gray-500 mb-4">Geen favoriete normale advertenties.</p>
                @endforelse

                {{-- Favoriete verhuuradvertenties --}}
                <h2 class="text-2xl font-bold text-gray-800 mt-12">🏷️ Mijn Favoriete Verhuuradvertenties</h2>
                @forelse ($favorieteVerhuur as $fav)
                    <div class="bg-white border border-gray-200 rounded-xl shadow p-4 mb-4">
                        <p class="font-semibold">{{ $fav->titel }}</p>
                        <a href="{{ route('verhuuradvertenties.show', $fav->id) }}" class="text-blue-600 hover:underline text-sm">👉 Bekijk advertentie</a>
                    </div>
                @empty
                    <p class="text-gray-500 mb-4">Geen favoriete verhuuradvertenties.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
