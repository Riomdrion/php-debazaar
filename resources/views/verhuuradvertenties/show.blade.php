@php use Carbon\Carbon; @endphp
<x-app-layout>
    <div class="p-6 max-w-2xl mx-auto space-y-6">
        <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6">
            <div class="flex space-x-6 justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $verhuurAdvertentie->titel }}</h1>
                    <p><strong>{{ __('adverts.beschrijving') }}:</strong> {{ $verhuurAdvertentie->beschrijving }}</p>
                    <p><strong>{{ __('adverts.Dagprijs') }}:</strong> €{{ number_format($verhuurAdvertentie->dagprijs, 2) }}</p>
                    <p><strong>{{ __('adverts.Borg') }}:</strong> €{{ number_format($verhuurAdvertentie->borg, 2) }}</p>
                    @if (auth()->id() === $verhuurAdvertentie->user_id)
                        <p><strong>{{ __('adverts.vervangingswaarde') }}:</strong> €{{ number_format($verhuurAdvertentie->vervangingswaarde, 2) }}</p>
                    @endif
                    <p class="text-gray-500 mt-2">{{ __('adverts.status') }}: <span class="{{ $verhuurAdvertentie->is_actief ? 'text-green-600' : 'text-red-600' }}">{{ $verhuurAdvertentie->is_actief ? __('adverts.actief') : __('adverts.Inactief') }}</span>
                        @if ($verhuurAdvertentie->is_actief)
                            <span class="text-gray-500">({{ round(now()->diffInDays($verhuurAdvertentie->created_at->addDays(30))) }} {{ __('adverts.dagen_over') }})</span>
                    @endif
                </div>
                <div>
                    @if ($verhuurAdvertentie->user && $verhuurAdvertentie->user->bedrijf)
                        <a href="{{ route('bedrijf.landing', ['slug' => $verhuurAdvertentie->user->bedrijf->slug]) }}"
                           class="text-blue-500 hover:underline">
                            {{ __('adverts.bekijk_bedrijfsreviews') }}
                        </a>
                    @endif
                    @if ($verhuurAdvertentie->qr_code)
                        <img src="{{ asset($verhuurAdvertentie->qr_code) }}" alt="QR Code" class="w-48 h-48">
                    @endif
                </div>
            </div>

            @if (auth()->id() === $verhuurAdvertentie->user_id)
                <div class="mt-6 flex justify-between">
                    <a href="{{ route('verhuuradvertenties.edit', $verhuurAdvertentie->id) }}"
                       class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                        ✏️  {{ __('adverts.Bewerken') }}
                    </a>

                    <form action="{{ route('verhuuradvertenties.destroy', $verhuurAdvertentie->id) }}" method="POST"
                          onsubmit="return confirm('Weet je zeker dat je deze advertentie wilt verwijderen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            🗑️ {{ __('adverts.Verwijderen') }}
                        </button>
                    </form>
                </div>
            @endif
        </div>
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">⭐ {{ __('adverts.Favoriet_maken') }}</h2>
            <form method="POST" action="{{ route('favorites.toggle') }}">
                @csrf
                <input type="hidden" name="verhuur_advertentie_id" value="{{ $verhuurAdvertentie->id }}">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" name="is_favoriet"
                           {{ $isFavoriet ? 'checked' : '' }} class="form-checkbox text-blue-600">
                    <label class="text-gray-700">{{ __('adverts.Toevoegen_aan_favorieten') }}</label>
                </div>
                <button type="submit"
                        class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    {{ __('adverts.opslaan') }}
                </button>
            </form>
        </div>
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">
                📅 {{ __('adverts.Verhuurplanning') }}
            </h2>

            @php
                $alleAgendaItems = $verhuurAdvertentie->agendaItems->sortBy('start');
            @endphp

            @if ($alleAgendaItems->isEmpty())
                <p class="text-gray-600">{{ __('adverts.Er_zijn_nog_geen_geplande_verhuurperiodes') }}.</p>
            @else
                <ul class="space-y-2">
                    @foreach ($alleAgendaItems as $item)
                        <li class="p-3">
                            <div class="mb-6">
                                <strong>{{ ucfirst($item->type) }}</strong><br>
                                @if (auth()->id() === $item->user_id)
                                    <strong>{{ __('adverts.Titel') }}:</strong> {{ $item->titel }}<br>
                                @endif
                                <strong>{{ __('adverts.Van') }}:</strong> {{ Carbon::parse($item->start)->format('d-m-Y H:i') }}<br>
                                <strong>{{ __('adverts.Tot') }}:</strong> {{ Carbon::parse($item->eind)->format('d-m-Y H:i') }}<br>
                            </div>
                            @if (Carbon::parse($item->eind)->isToday() || Carbon::parse($item->eind)->isPast())
                                @if (auth()->id() === $item->user_id)
                                    @if ($item->rental)
                                        <a href="{{ route('rentals.show', [$item->rental->id]) }}"
                                           class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                            {{ __('adverts.Bekijk_Rental') }}
                                        </a>
                                    @else
                                        <a href="{{ route('rentals.create', [$verhuurAdvertentie->id, $item->id]) }}"
                                           class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                            {{ __('adverts.Inleveren') }}
                                        </a>
                                    @endif
                                @endif
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100 mt-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">➕ {{ __('adverts.Agenda-item_toevoegen') }}</h2>

            <form method="POST" action="{{ route('agenda.store') }}">
                @csrf
                <input type="hidden" name="verhuur_advertentie_id" value="{{ $verhuurAdvertentie->id }}">
                <input type="hidden" name="type" value="gehuurd">
                <input type="hidden" name="titel" value="{{ auth()->user()->name }}_{{ $verhuurAdvertentie->titel }}_{{ now()->format('Y-m-d_H-i-s') }}">

                <div class="mb-4">
                    <label for="start" class="block font-semibold text-gray-700">{{ __('adverts.Startdatum_tijd') }}</label>
                    <input type="datetime-local" name="start" id="start" required
                           class="w-full border rounded-lg px-3 py-2 mt-1"
                           onchange="validateDates()">
                </div>

                <div class="mb-4">
                    <label for="eind" class="block font-semibold text-gray-700">{{ __('adverts.Einddatum_tijd') }}</label>
                    <input type="datetime-local" name="eind" id="eind" required
                           class="w-full border rounded-lg px-3 py-2 mt-1"
                           onchange="validateDates()">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                    {{ __('adverts.opslaan') }}
                </button>
            </form>
        </div>

        <!-- Review Placement Form -->
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100 mt-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">📝 {{ __('review.Review_plaatsen') }}</h2>
            <form method="POST" action="{{ route('reviews.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">{{ __('review.Review') }}</label>
                    <textarea name="tekst" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" rows="3" required></textarea>
                    <input type="hidden" value="{{ $verhuurAdvertentie->id }}" name="verhuur_advertentie_id">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">{{ __('review.Score') }} (1 t/m 5)</label>
                    <input type="number" name="score" min="1" max="5" class="w-20 border border-gray-300 rounded-lg px-2 py-1 focus:outline-none focus:ring focus:border-blue-300" required>
                </div>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    {{ __('review.Plaatsen') }}
                </button>
            </form>
        </div>

        <!-- Display Reviews -->
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100 mt-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">📊 {{ __('review.Reviews') }}</h2>
            @if($verhuurAdvertentie->reviews->isNotEmpty())
                <div class="space-y-4">
                    @foreach($verhuurAdvertentie->reviews as $review)
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
                <p class="text-gray-500">{{ __('review.Nog_geen_reviews_geplaatst') }}.</p>
            @endif
        </div>
    </div>
    </div>



    <script>
        function validateDates() {
            const start = document.getElementById('start').value;
            const eind = document.getElementById('eind').value;
            const agendaItems = @json($alleAgendaItems);

            if (start && eind && new Date(start) > new Date(eind)) {
                alert('Startdatum mag niet na einddatum vallen.');
                document.getElementById('start').value = '';
                document.getElementById('eind').value = '';
                return;
            }

            for (const item of agendaItems) {
                const itemStart = new Date(item.start);
                const itemEind = new Date(item.eind);

                if ((new Date(start) >= itemStart && new Date(start) <= itemEind) ||
                    (new Date(eind) >= itemStart && new Date(eind) <= itemEind) ||
                    (new Date(start) <= itemStart && new Date(eind) >= itemEind)) {
                    alert('De ingevoerde datum overlapt met een bestaande verhuurperiode.');
                    document.getElementById('start').value = '';
                    document.getElementById('eind').value = '';
                    return;
                }
            }
        }
    </script>
</x-app-layout>
