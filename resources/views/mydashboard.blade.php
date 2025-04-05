<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 max-w-7xl mx-auto ">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">📢  {{ __('adverts.Mijn_overzicht') }}</h1>

                {{-- Gewonnen biedingen --}}
                <h2 class="text-2xl font-bold text-gray-800 mt-12">🎯 {{ __('adverts.Mijn_Gekochte_Items') }}</h2>
                @forelse ($gewonnenBiedingen as $bod)
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 my-2 rounded-md shadow-sm  mb-4">
                        <p class="font-semibold">{{ $bod->advertentie->titel }}</p>
                        <p class="text-sm text-gray-600">{{ __('adverts.Geboden_bedrag') }}: €{{ number_format($bod->bedrag, 2, ',', '.') }}</p>
                        <a href="{{ route('advertenties.show', $bod->advertentie->id) }}" class="text-blue-600 hover:underline text-sm">👉 {{ __('adverts.Bekijk_advertentie') }}</a>
                    </div>
                @empty
                    <p class="text-gray-500 mb-4">{{ __('adverts.Je_hebt_nog_geen_items_gewonnen') }}.</p>
                @endforelse

                {{-- Favoriete normale advertenties --}}
                <h2 class="text-2xl font-bold text-gray-800 mt-12">❤️ {{ __('adverts.Mijn_Favoriete_Advertenties') }}</h2>
                @forelse ($favorieteAdvertenties as $fav)
                    <div class="bg-white border border-gray-200 rounded-xl shadow p-4 my-2 mb-4">
                        <p class="font-semibold">{{ $fav->titel }}</p>
                        <a href="{{ route('advertenties.show', $fav->id) }}" class="text-blue-600 hover:underline text-sm">👉 {{ __('adverts.Bekijk_advertentie') }}</a>
                    </div>
                @empty
                    <p class="text-gray-500 mb-4">{{ __('adverts.Mijn_Favoriete_Advertenties') }}.</p>
                @endforelse

                {{-- Favoriete verhuuradvertenties --}}
                <h2 class="text-2xl font-bold text-gray-800 mt-12">🏷️ {{ __('adverts.Mijn_Favoriete_Verhuuradvertenties') }}</h2>
                @forelse ($favorieteVerhuur as $fav)
                    <div class="bg-white border border-gray-200 rounded-xl shadow p-4 mb-4">
                        <p class="font-semibold">{{ $fav->titel }}</p>
                        <a href="{{ route('verhuuradvertenties.show', $fav->id) }}" class="text-blue-600 hover:underline text-sm">👉 {{ __('adverts.Bekijk_advertentie') }}</a>
                    </div>
                @empty
                    <p class="text-gray-500 mb-4">{{ __('adverts.Geen_favoriete_verhuuradvertenties') }}.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
