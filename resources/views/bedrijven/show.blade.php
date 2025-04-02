<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto space-y-6">
        <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200 flex space-x-6 justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $bedrijf->naam }}</h1>
                <p class="text-gray-600 mt-4">{{ $bedrijf->beschrijving }}</p>
            </div>
        </div>

        <!-- Review Placement Form for Company -->
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100 mt-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">📝 Review plaatsen</h2>
            <form method="POST" action="{{ route('reviews.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Review</label>
                    <textarea name="tekst" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" rows="3" required></textarea>
                    <input type="hidden" value="{{ $bedrijf->id }}" name="bedrijf_id">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Score (1 t/m 5)</label>
                    <input type="number" name="score" min="1" max="5" class="w-20 border border-gray-300 rounded-lg px-2 py-1 focus:outline-none focus:ring focus:border-blue-300" required>
                </div>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    Plaatsen
                </button>
            </form>
        </div>

        <!-- Display Reviews for Company -->
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100 mt-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">📊 Reviews</h2>
            @if($bedrijf->reviews->isNotEmpty())
                <div class="space-y-4">
                    @foreach($bedrijf->reviews as $review)
                        <div class="border-b pb-4">
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center space-x-2">
                                    <span class="font-medium text-gray-700">{{ $review->user->name }}</span>
                                    <div class="flex text-yellow-500">
                                        @for($i = 1; $i <= $review->rating; $i++)
                                            ★
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-600">{{ $review->bericht }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Nog geen reviews geplaatst.</p>
            @endif
        </div>
    </div>
</x-app-layout>
