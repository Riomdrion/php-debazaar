<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 max-w-7xl mx-auto space-y-6">
                <!-- Rest of your content remains unchanged -->
                <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">📢 Recente Advertenties</h1>

                <!-- Normal Advertisements -->
                <h2 class="text-2xl font-bold text-gray-800">Normale Advertenties</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse ($recentNormalAds as $advertentie)
                        <!-- Advertentie cards -->
                    @empty
                        <div class="col-span-full text-center text-gray-500 mt-8">
                            Geen normale advertenties gevonden.
                        </div>
                    @endforelse
                </div>

                <!-- Rental Advertisements -->
                <h2 class="text-2xl font-bold text-gray-800 mt-8">Verhuur Advertenties</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse ($recentRentalAds as $advertentie)
                        <!-- Advertentie cards -->
                    @empty
                        <div class="col-span-full text-center text-gray-500 mt-8">
                            Geen verhuur advertenties gevonden.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
