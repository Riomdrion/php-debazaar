<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">{{ $bedrijf->naam }}</h1>
       <a href="{{ route('pagebuilder.edit', ['slug' => $bedrijf->slug]) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Pagebuilder</a>
        @foreach($components as $component)
            @php
                $type = $component->type;
                $data = $component->data;
            @endphp

            @if($type === 'text')
                <div class="mb-6">
                    <h2 class="text-xl font-semibold">{{ $data['title'] ?? '' }}</h2>
                    <p class="text-gray-700 mt-2">{{ $data['body'] ?? '' }}</p>
                </div>
            @elseif($type === 'image')
                <div class="mb-6">
                    <img src="{{ $data['url'] ?? '#' }}" alt="{{ $data['alt'] ?? 'afbeelding' }}" class="rounded shadow-md max-w-full">
                </div>
            @elseif($type === 'featured_ads')
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-2">Uitgelichte advertenties</h2>
                    {{-- Hier kun je later dynamisch advertenties ophalen op basis van $data['ids'] of criteria --}}
                    <p class="text-sm text-gray-500">Component voor advertenties volgt nog…</p>
                </div>
            @else
                <div class="mb-6">
                    <p class="text-red-500">Onbekend component type: {{ $type }}</p>
                </div>
            @endif
        @endforeach
    </div>
</x-app-layout>
