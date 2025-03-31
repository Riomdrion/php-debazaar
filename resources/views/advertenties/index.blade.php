<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Advertenties</h1>

        <form method="GET" class="mb-4">
            <input type="text" name="zoek" value="{{ request('zoek') }}" placeholder="Zoek..."
                   class="input input-bordered w-full max-w-xs">
        </form>

        <a href="{{ route('advertenties.create') }}" class="btn btn-primary mb-4">Nieuwe advertentie</a>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($advertenties as $advertentie)
                <div class="p-4 border rounded-lg shadow hover:shadow-lg transition">
                    <h2 class="text-lg font-semibold">{{ $advertentie->titel }}</h2>
                    <p class="text-sm text-gray-600">{{ Str::limit($advertentie->beschrijving, 100) }}</p>
                    <p class="text-sm font-bold mt-2">&euro; {{ $advertentie->prijs }}</p>
                    <a href="{{ route('advertenties.show', $advertentie) }}" class="text-blue-500 mt-2 inline-block">Bekijk</a>
                </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $advertenties->links() }}</div>
    </div>
</x-app-layout>
