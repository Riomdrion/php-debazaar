<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="max-w-4xl mx-auto pt-12 px-6">
            <div class="flex justify-between items-center mb-10">
                <h1 class="text-4xl font-extrabold text-gray-800">{{ $bedrijf->naam }}</h1>
                @if(auth()->user()->id == $bedrijf->user_id)
                    <a href="{{ route('pagebuilder.edit', ['slug' => $bedrijf->slug]) }}"
                       class="inline-block px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                        ✏️ {{ __('comp.Opslaan') }}
                    </a>
                @endif
            </div>

            @foreach($components as $component)
                @php
                    $type = $component->type;
                    $data = $component->data;
                @endphp

                @if($type === 'text')
                    <div class="mb-10 bg-white shadow-sm rounded-lg p-6">
                        <h2 class="text-2xl font-semibold text-gray-900">{{ $data['title'] ?? '' }}</h2>
                        <p class="text-gray-700 mt-2 leading-relaxed">{{ $data['body'] ?? '' }}</p>
                    </div>

                @elseif($type === 'image')
                    <div class="mb-10">
                        <img src="{{ $data['url'] ?? '#' }}"
                             alt="{{ $data['alt'] ?? 'Afbeelding' }}"
                             class="rounded-lg shadow-md w-full object-cover">
                    </div>

                @elseif($type === 'video')
                    <div class="mb-10 aspect-w-16 aspect-h-9 flex justify-center items-center rounded-lg overflow-hidden">
                        <iframe class="rounded-l-md" width="800" height="450" src="https://www.youtube.com/embed/{{ $data['embed'] ?? '#' }}"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>

                @elseif($type === 'button')
                    <div class="mb-10 text-center">
                        <a href="{{ $data['url'] ?? '#' }}"
                           class="inline-block bg-indigo-600 text-white font-medium px-6 py-3 rounded-full shadow hover:bg-indigo-700 transition">
                            {{ $data['label'] ?? 'Klik hier' }}
                        </a>
                    </div>

                @else
                    <div class="mb-6 text-red-500 font-medium">
                        {{ __('comp.Onbekend_component_type') }}: {{ $type }}
                    </div>
                @endif
            @endforeach
        </div>
        <!-- Review Placement Form for Company -->
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">📝 {{ __('review.Review_plaatsen') }}</h2>
            <form method="POST" action="{{ route('reviews.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1"> {{ __('review.Review') }}</label>
                    <textarea name="tekst" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" rows="3" required></textarea>
                    <input type="hidden" value="{{ $bedrijf->id }}" name="bedrijf_id">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1"> {{ __('review.Score') }} (1 t/m 5)</label>
                    <input type="number" name="score" min="1" max="5" class="w-20 border border-gray-300 rounded-lg px-2 py-1 focus:outline-none focus:ring focus:border-blue-300" required>
                </div>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    {{ __('review.Plaatsen') }}
                </button>
            </form>
        </div>

        <!-- Display Reviews for Company -->
        <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100 mt-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">📊  {{ __('review.Reviews') }}</h2>
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
                <p class="text-gray-500"> {{ __('review.Nog_geen_reviews_geplaatst') }}.</p>
            @endif
        </div>
    </div>
</x-app-layout>
