@php
    $json = json_encode($data ?? []);
@endphp

<div class="p-4 border rounded mb-4 bg-white shadow" data-index="{{ $index }}">
    <label class="block font-semibold mb-1">Type</label>
    <select name="components[{{ $index }}][type]" class="component-type w-full border p-2 rounded mb-2" required>
        <option value="">-- Kies een type --</option>
        <option value="text" {{ $type === 'text' ? 'selected' : '' }}>Tekst</option>
        <option value="image" {{ $type === 'image' ? 'selected' : '' }}>Afbeelding</option>
        <option value="video" {{ $type === 'video' ? 'selected' : '' }}>Video</option>
        <option value="button" {{ $type === 'button' ? 'selected' : '' }}>Knop</option>
    </select>

    <div class="dynamic-fields mb-2">
        @if ($type === 'text')
            <label class="block text-sm">Titel</label>
            <input type="text" class="title w-full border p-2 rounded mb-2" value="{{ $data['title'] ?? '' }}" name="components[{{ $index }}][data][body]">
            <label class="block text-sm">Tekst</label>
            <textarea name="components[{{ $index }}][data][body]" class="body w-full border p-2 rounded mb-2">{{ $data['body'] ?? '' }}</textarea>
        @elseif ($type === 'image')
            <label class="block text-sm">Afbeeldings-URL</label>
            <input type="text" class="url w-full border p-2 rounded mb-2" value="{{ $data['url'] ?? '' }}" name="components[{{ $index }}][data][url]">
            <label class="block text-sm">Alt-tekst</label>
            <input type="text" class="alt w-full border p-2 rounded mb-2" value="{{ $data['alt'] ?? '' }}" name="components[{{ $index }}][data][alt]">
        @elseif ($type === 'video')
            <label class="block text-sm">YouTube Embed URL</label>
            <input type="text" class="embed w-full border p-2 rounded mb-2" value="{{ $data['embed'] ?? '' }}" name="components[{{ $index }}][data][embed]">
        @elseif ($type === 'button')
            <label class="block text-sm">Knoptekst</label>
            <input type="text" class="label w-full border p-2 rounded mb-2" value="{{ $data['label'] ?? '' }}" name="components[{{ $index }}][data][label]">
            <label class="block text-sm">Link</label>
            <input type="text" class="url w-full border p-2 rounded mb-2" value="{{ $data['url'] ?? '' }}" name="components[{{ $index }}][data][url]">
        @endif
    </div>

    <textarea name="components[{{ $index }}][data]" class="data-json hidden">{!! $json !!}</textarea>

    <label class="block font-semibold mb-1">Volgorde</label>
    <input type="number" name="components[{{ $index }}][order]" value="{{ $order }}" class="w-full border p-2 rounded">
</div>
