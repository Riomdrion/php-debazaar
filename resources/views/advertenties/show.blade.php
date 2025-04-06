<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto space-y-6">

        @if (auth()->id() === $advertentie->user_id)
            <div class="flex justify-end">
                <a href="{{ route('advertenties.edit', $advertentie->id) }}"
                   class="text-blue-600 hover:underline font-medium">
                    ✏️ {{ __('adverts.bewerken') }}
                </a>
            </div>
        @endif

        <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200 flex space-x-6 justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $advertentie->titel }}</h1>
                <p class="text-gray-600 mt-4">{{ $advertentie->beschrijving }}</p>
                <p class="text-xl font-semibold text-green-600 mt-4">&euro; {{ number_format($advertentie->prijs, 2, ',', '.') }}</p>
                <p class="text-gray-500 mt-2">{{ __('adverts.status') }}: <span class="{{ $advertentie->is_actief ? 'text-green-600' : 'text-red-600' }}">{{ $advertentie->is_actief ? __('adverts.actief') : __('adverts.Inactief') }}</span>
                @if ($advertentie->is_actief)
                    <span class="text-gray-500">({{ round(now()->diffInDays($advertentie->created_at->addDays(30))) }} {{ __('adverts.dagen_over') }})</span>
                @endif
            </div>
            <div>
                @if ($advertentie->user && $advertentie->user->bedrijf)
                    <a href="{{ route('bedrijf.landing', ['slug' => $advertentie->user->bedrijf->slug]) }}"
                       class="text-blue-500 hover:underline">
                        {{ __('adverts.Bekijk_Bedrijfsreviews') }}
                    </a>
                @endif
                @if ($advertentie->qr_code)
                    <img src="{{ asset($advertentie->qr_code) }}" alt="QR Code" class="w-48 h-48">
                @endif
            </div>
        </div>

        @if ($advertentie->gekoppeldeAdvertenties->isNotEmpty())
            <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">{{ __('adverts.Gekoppelde_advertenties') }}</h3>
                <ul class="list-disc ml-6 space-y-2">
                    @foreach ($advertentie->gekoppeldeAdvertenties as $gekoppeld)
                        <li>
                            <a href="{{ route('advertenties.show', $gekoppeld->id) }}"
                               class="text-blue-500 hover:underline">
                                {{ $gekoppeld->titel }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Favorite Placement Form -->
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">⭐ {{ __('adverts.Favoriet_maken') }}</h2>
            <form method="POST" action="{{ route('favorites.toggle') }}">
                @csrf
                <input type="hidden" name="advertentie_id" value="{{ $advertentie->id }}">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" name="is_favoriet" dusk="favorite-checkbox"
                           {{ $isFavoriet ? 'checked' : '' }} class="form-checkbox text-blue-600">
                    <label class="text-gray-700">{{ __('adverts.Toevoegen_aan_favorieten') }}</label>
                </div>
                <button type="submit" dusk="favoriet-knop"
                        class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    {{ __('adverts.opslaan') }}
                </button>
            </form>
        </div>

        <!-- bid placement  form -->
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100 mt-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">💰 {{ __('adverts.Bod_plaatsen') }}</h2>
            @if ($advertentie->bids->count() < 4)
                @if ($advertentie->bids->where('WinningBid', true)->isEmpty())
                    <form method="POST" action="{{ route('bids.store', $advertentie->id) }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-1">{{ __('adverts.bedrag') }} (€)</label>
                            <input type="number" name="bedrag" min="0.01" step="0.01" dusk="bieding-input"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                                   required>
                        </div>
                        <button type="submit" dusk="bieding-button"
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                            {{ __('adverts.bedrag') }}
                        </button>
                    </form>
                @else
                    <p class="text-red-600 font-medium">{{ __('adverts.Er_is_al_een_winnend_bod') }}</p>
                @endif
            @else
                <p class="text-red-600 font-medium" id="max-bid-error" dusk="max-bid-error">{{ __('adverts.Er_zijn_al_4_biedingen_geplaatst_voor_deze_advertentie') }}.</p>
            @endif
        </div>
            <!-- Display Bids -->
            <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100 mt-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">📄 {{ __('adverts.Bestaande_biedingen') }}</h2>
                @if($advertentie->bids->count() > 0)
                    <ul class="space-y-2">
                        @if ($advertentie->bids->where('WinningBid', true)->isEmpty())
                            @foreach($advertentie->bids->sortByDesc('bedrag') as $bid)
                                <li dusk="bid-item" id="bid-item" class="bid-item border border-gray-200 rounded-lg px-4 py-2 bg-gray-50 flex justify-between items-center">
                                    <span>€{{ number_format($bid->bedrag, 2, ',', '.') }}</span>
                                    <span class="text-sm text-gray-500">{{ __('adverts.gebruiker') }}: {{ $bid->user->name }}</span>
                                    <form method="POST" action="{{ route('bids.update')}}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="WinningBid" value="1">
                                        <input type="hidden" name="bid_id" value="{{ $bid->id }}">
                                        <input type="hidden" name="advertentie_id" value="{{ $advertentie->id }}">
                                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                            {{ __('adverts.Zet_als_winnend_bod') }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('bids.destroy', $advertentie->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                            {{ __('adverts.Verwijder_bod') }}
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        @else
                            <li class="border border-green-400 rounded-lg px-4 py-2 bg-green-200 flex justify-between items-center">
                                <span>€{{ number_format($advertentie->bids->where('WinningBid', true)->first()->bedrag, 2, ',', '.') }}</span>
                                <span class="text-sm text-gray-500">{{ __('adverts.gebruiker') }}: {{ $advertentie->bids->where('WinningBid', true)->first()->user->name }}</span>
                            </li>
                        @endif
                    </ul>
                @else
                    <p class="text-gray-600">{{ __('adverts.Er_zijn_nog_geen_biedingen_geplaatst_voor_deze_advertentie') }}</p>
                @endif
            </div>


            <!-- Review Placement Form -->
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100 mt-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">📝 {{ __('adverts.Review_plaatsen') }}</h2>
            <form method="POST" action="{{ route('reviews.store')}}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">{{ __('adverts.Review') }}</label>
                    <textarea name="tekst" dusk="review-tekst"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                              rows="3" required></textarea>
                    <input type="hidden" value="{{ $advertentie->id }}" name="advertentie_id">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Score (1 t/m 5)</label>
                    <input type="number" name="score" min="1" max="5" dusk="review-score"
                           class="w-20 border border-gray-300 rounded-lg px-2 py-1 focus:outline-none focus:ring focus:border-blue-300"
                           required>
                </div>
                <button type="submit" dusk="review-knop"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    {{ __('adverts.plaatsen') }}
                </button>
            </form>
        </div>

        <!-- Display Reviews -->
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100 mt-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">📊 {{ __('adverts.Review') }}</h2>
            @if($advertentie->reviews->isNotEmpty())
                <div class="space-y-4">
                    @foreach($advertentie->reviews as $review)
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
                <p class="text-gray-500">{{ __('adverts.Nog_geen_reviews_geplaatst') }}.</p>
            @endif
        </div>
    </div>
</x-app-layout>
