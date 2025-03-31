<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold">{{ $advertentie->titel }}</h1>
        <p class="text-gray-700 mt-2">{{ $advertentie->beschrijving }}</p>
        <p class="text-lg font-semibold mt-4">&euro; {{ number_format($advertentie->prijs, 2, ',', '.') }}</p>

        <form method="POST" action="{{ route('favorieten.store', ['advertentie' => $advertentie->id]) }}" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-secondary">Toevoegen aan favorieten</button>
        </form>

        <form method="POST" action="{{ route('reviews.store', ['advertentie' => $advertentie->id]) }}" class="mt-6">
            @csrf
            <label class="block mb-1">Review</label>
            <textarea name="tekst" class="textarea textarea-bordered w-full mb-2" rows="3" required></textarea>

            <label class="block mb-1">Score</label>
            <input type="number" name="score" min="1" max="5" class="input input-bordered w-20" required>

            <button type="submit" class="btn btn-primary mt-2">Plaatsen</button>
        </form>
    </div>
</x-app-layout>
