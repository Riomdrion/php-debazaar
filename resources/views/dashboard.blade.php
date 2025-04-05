<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 max-w-7xl mx-auto space-y-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">📢 {{ __('adverts.Recente_Advertenties') }}</h1>

                <form method="GET" class="w-full md:w-1/3">
                    <input type="text" name="zoek" value="{{ request('zoek') }}"
                           placeholder="🔍 {{ __('adverts.Zoek_op_titel') }}..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-400">
                </form>

                <!-- Normal Advertisements -->
                <h2 class="text-2xl font-bold text-gray-800">{{ __('adverts.Normale_Advertenties') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse ($recentNormalAds as $advertentie)
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
                            {{ __('adverts.Geen_normale_advertenties_gevonden') }}
                        </div>
                    @endforelse
                </div>
                <div class="mt-4">
                    {{ $recentNormalAds->appends(['rentalPage' => $rentalPage])->links() }}
                </div>

                <!-- Rental Advertisements -->
                <h2 class="text-2xl font-bold text-gray-800 mt-8">{{ __('adverts.Verhuur_Advertenties') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse ($recentRentalAds as $verhuuradvertentie)
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-5 flex flex-col justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $verhuuradvertentie->titel }}</h2>
                                <p class="text-gray-600 text-sm">{{ Str::limit($verhuuradvertentie->beschrijving, 100) }}</p>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-green-600 font-bold text-lg">&euro; {{ number_format($verhuuradvertentie->dagprijs, 2, ',', '.') }} per dag</span>
                                <a href="{{ route('verhuuradvertenties.show', $verhuuradvertentie->id) }}"
                                   class="text-blue-600 font-medium hover:underline">
                                    👉 {{ __('adverts.bekijk') }}
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-500 mt-8">
                            {{ __('adverts.Geen_verhuur_advertenties_gevonden') }}
                        </div>
                    @endforelse
                </div>
                <div class="mt-4">
                    {{ $recentRentalAds->appends(['normalPage' => $normalPage])->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
