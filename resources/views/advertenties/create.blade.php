<x-app-layout>
    <div class="p-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Nieuwe Advertentie</h1>

        <form method="POST" action="{{ route('advertenties.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block mb-1">Titel</label>
                <input type="text" name="titel" class="input input-bordered w-full" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Beschrijving</label>
                <textarea name="beschrijving" class="textarea textarea-bordered w-full" rows="4" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Prijs</label>
                <input type="number" name="prijs" step="0.01" class="input input-bordered w-full" required>
            </div>

            <div class="mb-4">
                <div class="mb-4">
                    <label class="block mb-1">Koppel andere advertenties</label>
                    <select name="koppelingen[]" class="select select-bordered w-full" multiple>
                        @foreach ($alleAdvertenties as $optie)
                            <option value="{{ $optie->id }}">{{ $optie->titel }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Plaatsen</button>
        </form>
    </div>
</x-app-layout>
