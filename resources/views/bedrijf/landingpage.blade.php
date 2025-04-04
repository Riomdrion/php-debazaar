<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-6">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-4xl font-extrabold text-gray-800">{{ $bedrijf->naam }}</h1>
            @if(auth()->user()->id == $bedrijf->user_id)
                <a href="{{ route('pagebuilder.edit', ['slug' => $bedrijf->slug]) }}"
                   class="inline-block px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                    ✏️ Pagina Bewerken
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
                    Onbekend component type: {{ $type }}
                </div>
            @endif
        @endforeach
    </div>
</x-app-layout>
