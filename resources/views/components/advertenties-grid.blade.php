@props(['items', 'routeName', 'type'])

<h2 class="text-2xl font-bold text-gray-800 mt-8">{{ $type === 'verhuur' ? __('adverts.Verhuur_Advertenties') : __('adverts.Normale_Advertenties') }}</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse ($items as $item)
        <div class="bg-white border border-gray-200 rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-5 flex flex-col justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $item->titel }}</h2>
                <p class="text-gray-600 text-sm">{{ Str::limit($item->beschrijving, 100) }}</p>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-green-600 font-bold text-lg">
                    &euro; {{ number_format($type === 'verhuur' ? $item->dagprijs : $item->prijs, 2, ',', '.') }}
                    {{ $type === 'verhuur' ? 'per dag' : '' }}
                </span>
                <a href="{{ route($routeName, $item->id) }}" class="text-blue-600 font-medium hover:underline">👉 {{ __('adverts.bekijk') }}</a>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center text-gray-500 mt-8">
            {{ $type === 'verhuur' ? __('adverts.Geen_verhuur_advertenties_gevonden') : __('adverts.Geen_normale_advertenties_gevonden') }}
        </div>
    @endforelse
</div>
