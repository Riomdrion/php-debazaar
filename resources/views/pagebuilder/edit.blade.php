<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Pagebuilder voor {{ $bedrijf->naam }}</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pagebuilder.update', $bedrijf->slug) }}" enctype="multipart/form-data">
            @csrf

            <div id="components-list">
                {{-- bestaande componenten --}}
                @foreach ($bedrijf->components as $index => $component)
                    <div class="component-wrapper"
                         data-index="{{ $index }}"
                         data-type="{{ $component->type }}"
                         data-data='@json($component->data)'
                         data-order="{{ $component->order ?? 0 }}">
                    </div>
                @endforeach

            </div>

            <button type="button" id="add-component" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mb-6">
                + Component toevoegen
            </button>

            <div>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">
                    Opslaan
                </button>
            </div>
        </form>
    </div>

    <script>
        let componentIndex = {{ count($components) }};

        function renderFields(index, type, data = {}) {
            let html = `
            <div class="p-4 border rounded mb-4 bg-white shadow" data-index="${index}">
                <label class="block font-semibold mb-1">Type</label>
                <select name="components[${index}][type]" class="component-type w-full border p-2 rounded mb-2" required>
                    <option value="">-- Kies een type --</option>
                    <option value="text" ${type === 'text' ? 'selected' : ''}>Tekst</option>
                    <option value="image" ${type === 'image' ? 'selected' : ''}>Afbeelding</option>
                    <option value="video" ${type === 'video' ? 'selected' : ''}>Video</option>
                    <option value="button" ${type === 'button' ? 'selected' : ''}>Knop</option>
                </select>

                <div class="dynamic-fields mb-2">`;

            if (type === 'text') {
                html += `
                <label class="block text-sm">Titel</label>
                <input type="text" name="components[${index}][data][title]" value="${data.title ?? ''}" class="title w-full border p-2 rounded mb-2">
                <label class="block text-sm">Tekst</label>
                <textarea name="components[${index}][data][body]" class="body w-full border p-2 rounded mb-2">${data.body ?? ''}</textarea>
            `;
            } else if (type === 'image') {
                html += `
                <label class="block text-sm">Afbeeldings-URL</label>
                <input type="text" name="components[${index}][data][url]" value="${data.url ?? ''}" class="url w-full border p-2 rounded mb-2">
                <label class="block text-sm">Alt-tekst</label>
                <input type="text" name="components[${index}][data][alt]" value="${data.alt ?? ''}" class="alt w-full border p-2 rounded mb-2">
            `;
            } else if (type === 'video') {
                html += `
                <label class="block text-sm">YouTube Embed URL</label>
                <input type="text" name="components[${index}][data][embed]" value="${data.embed ?? ''}" class="embed w-full border p-2 rounded mb-2">
            `;
            } else if (type === 'button') {
                html += `
                <label class="block text-sm">Knoptekst</label>
                <input type="text" name="components[${index}][data][label]" value="${data.label ?? ''}" class="label w-full border p-2 rounded mb-2">
                <label class="block text-sm">Link</label>
                <input type="text" name="components[${index}][data][url]" value="${data.url ?? ''}" class="url w-full border p-2 rounded mb-2">
            `;
            }

            html += `
                </div>

                <label class="block font-semibold mb-1">Volgorde</label>
                <input type="number" name="components[${index}][order]" value="${data.order ?? 0}" class="w-full border p-2 rounded">
            </div>
        `;

            return html;
        }

        // Laad bestaande componenten
        document.querySelectorAll('.component-wrapper').forEach(wrapper => {
            const index = wrapper.dataset.index;
            const type = wrapper.dataset.type;
            const data = JSON.parse(wrapper.dataset.data || '{}');
            data.order = wrapper.dataset.order ?? 0;

            wrapper.outerHTML = renderFields(index, type, data);
        });

        // Voeg nieuwe component toe
        document.getElementById('add-component').addEventListener('click', function () {
            const list = document.getElementById('components-list');
            const index = componentIndex++;

            list.insertAdjacentHTML('beforeend', renderFields(index, '', {}));
        });

        // Dynamisch aanpassen velden als je type verandert
        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('component-type')) {
                const wrapper = e.target.closest('[data-index]');
                const index = wrapper.getAttribute('data-index');
                const type = e.target.value;
                wrapper.outerHTML = renderFields(index, type, {});
            }
        });
    </script>
</x-app-layout>
