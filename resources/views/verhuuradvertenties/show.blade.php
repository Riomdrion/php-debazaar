@php use Carbon\Carbon; @endphp
<x-app-layout>
    <div class="p-6 max-w-2xl mx-auto space-y-6">
        <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6">
            <div class="flex space-x-6 justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $verhuurAdvertentie->titel }}</h1>
                    <p><strong>Beschrijving:</strong> {{ $verhuurAdvertentie->beschrijving }}</p>
                    <p><strong>Dagprijs:</strong> €{{ number_format($verhuurAdvertentie->dagprijs, 2) }}</p>
                    <p><strong>Borg:</strong> €{{ number_format($verhuurAdvertentie->borg, 2) }}</p>
                    <p><strong>Status:</strong><span
                                class="{{ $verhuurAdvertentie->is_actief ? 'text-green-600' : 'text-red-600' }}">{{ $verhuurAdvertentie->is_actief ? 'Actief' : 'Inactief' }}</span>
                    </p>
                </div>
                <div>
                    @if ($verhuurAdvertentie->user && $verhuurAdvertentie->user->bedrijf)
                        <a href="{{ route('bedrijven.show', ['bedrijf' => $verhuurAdvertentie->user->bedrijf->id]) }}"
                           class="text-blue-500 hover:underline">
                            Bekijk Bedrijfsreviews
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
                        ✏️ Bewerken
                    </a>

                    <form action="{{ route('verhuuradvertenties.destroy', $verhuurAdvertentie->id) }}" method="POST"
                          onsubmit="return confirm('Weet je zeker dat je deze advertentie wilt verwijderen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            🗑️ Verwijderen
                        </button>
                    </form>
                </div>
            @endif
        </div>
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">⭐ Favoriet maken</h2>
            <form method="POST" action="{{ route('favorites.toggle') }}">
                @csrf
                <input type="hidden" name="verhuur_advertentie_id" value="{{ $verhuurAdvertentie->id }}">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" name="is_favoriet"
                           {{ $isFavoriet ? 'checked' : '' }} class="form-checkbox text-blue-600">
                    <label class="text-gray-700">Toevoegen aan favorieten</label>
                </div>
                <button type="submit"
                        class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Opslaan
                </button>
            </form>
        </div>
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">
                📅 Verhuurplanning
            </h2>

            @php
                $alleAgendaItems = $verhuurAdvertentie->agendaItems->sortBy('start');
            @endphp

            @if ($alleAgendaItems->isEmpty())
                <p class="text-gray-600">Er zijn nog geen geplande verhuurperiodes.</p>
            @else
                <ul class="space-y-2">
                    @foreach ($alleAgendaItems as $item)
                        <li class="border border-gray-200 rounded-lg p-3">
                            <strong>{{ ucfirst($item->type) }}</strong><br>
                            @if (auth()->id() === $item->user_id)
                                <strong>Titel:</strong> {{ $item->titel }}<br>
                            @endif
                            <strong>Van:</strong> {{ Carbon::parse($item->start)->format('d-m-Y H:i') }}<br>
                            <strong>Tot:</strong> {{ Carbon::parse($item->eind)->format('d-m-Y H:i') }}<br>
                            @if (Carbon::parse($item->eind)->isToday() || Carbon::parse($item->eind)->isPast())
                                @if (auth()->id() === $item->user_id)
                                    <a href="{{ route('rentals.create', $item) }}"
                                       class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                        Inleveren
                                    </a>
                                @endif
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100 mt-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">➕ Agenda-item toevoegen</h2>

            <form method="POST" action="{{ route('agenda.store') }}">
                @csrf
                <input type="hidden" name="verhuur_advertentie_id" value="{{ $verhuurAdvertentie->id }}">
                <input type="hidden" name="type" value="gehuurd">
                <input type="hidden" name="titel" value="{{ auth()->user()->name }}_{{ $verhuurAdvertentie->titel }}_{{ now()->format('Y-m-d_H-i-s') }}">

                <div class="mb-4">
                    <label for="start" class="block font-semibold text-gray-700">Startdatum/tijd</label>
                    <input type="datetime-local" name="start" id="start" required
                           class="w-full border rounded-lg px-3 py-2 mt-1"
                           onchange="validateDates()">
                </div>

                <div class="mb-4">
                    <label for="eind" class="block font-semibold text-gray-700">Einddatum/tijd</label>
                    <input type="datetime-local" name="eind" id="eind" required
                           class="w-full border rounded-lg px-3 py-2 mt-1"
                           onchange="validateDates()">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                    Opslaan
                </button>
            </form>
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
