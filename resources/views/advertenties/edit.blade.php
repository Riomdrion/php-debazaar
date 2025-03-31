<x-app-layout>
    <div class="p-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Bewerk Advertentie</h1>

        <form method="POST" action="{{ route('advertenties.update', $advertentie) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1">Titel</label>
                <input type="text" name="titel" value="{{ old('titel', $advertentie->titel) }}" class="input input-bordered w-full" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Beschrijving</label>
                <textarea name="beschrijving" class="textarea textarea-bordered w-full" rows="4" required>{{ old('beschrijving', $advertentie->beschrijving) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Prijs</label>
                <input type="number" name="prijs" step="0.01" value="{{ old('prijs', $advertentie->prijs) }}" class="input input-bordered w-full" required>
            </div>

            <button type="submit" class="btn btn-primary">Opslaan</button>
        </form>
    </div>
</x-app-layout>
