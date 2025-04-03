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
                    <x-component-builder
                        :index="$index"
                        :type="$component->type"
                        :data="$component->data"
                        :order="$component->order ?? 0"
                    />
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

        document.getElementById('add-component').addEventListener('click', function () {
            const list = document.getElementById('components-list');
            const index = componentIndex++;

            const wrapper = document.createElement('div');
            wrapper.classList.add('p-4', 'border', 'rounded', 'mb-4', 'bg-white', 'shadow');
            wrapper.setAttribute('data-index', index);
            wrapper.innerHTML = `
            <label class="block font-semibold mb-1">Type</label>
            <select name="components[${index}][type]" class="component-type w-full border p-2 rounded mb-2" required>
                <option value="">-- Kies een type --</option>
                <option value="text">Tekst</option>
                <option value="image">Afbeelding</option>
                <option value="video">Video</option>
                <option value="button">Knop</option>
            </select>

            <div class="dynamic-fields mb-2"></div>

            <textarea name="components[${index}][data]" class="data-json hidden"></textarea>

            <label class="block font-semibold mb-1">Volgorde</label>
            <input type="number" name="components[${index}][order]" value="0" class="w-full border p-2 rounded">
        `;

            list.appendChild(wrapper);
        });

        // Dynamisch veld aanpassen bij wijzigen van type
        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('component-type')) {
                const wrapper = e.target.closest('[data-index]');
                const index = wrapper.getAttribute('data-index');
                const fields = wrapper.querySelector('.dynamic-fields');
                const jsonField = wrapper.querySelector('.data-json');

                let html = '';
                let data = {};

                switch (e.target.value) {
                    case 'text':
                        html = `
                        <label class="block text-sm">Titel</label>
                        <input type="text" class="title w-full border p-2 rounded mb-2">
                        <label class="block text-sm">Tekst</label>
                        <textarea class="body w-full border p-2 rounded mb-2"></textarea>
                    `;
                        break;
                    case 'image':
                        html = `
                        <label class="block text-sm">Afbeeldings-URL</label>
                        <input type="text" class="url w-full border p-2 rounded mb-2">
                        <label class="block text-sm">Alt-tekst</label>
                        <input type="text" class="alt w-full border p-2 rounded mb-2">
                    `;
                        break;
                    case 'video':
                        html = `
                        <label class="block text-sm">YouTube Embed URL</label>
                        <input type="text" class="embed w-full border p-2 rounded mb-2">
                    `;
                        break;
                    case 'button':
                        html = `
                        <label class="block text-sm">Knoptekst</label>
                        <input type="text" class="label w-full border p-2 rounded mb-2">
                        <label class="block text-sm">Link</label>
                        <input type="text" class="url w-full border p-2 rounded mb-2">
                    `;
                        break;
                }

                fields.innerHTML = html;

                // Realtime sync van data naar JSON-veld
                fields.addEventListener('input', function () {
                    const inputs = fields.querySelectorAll('input, textarea');
                    const obj = {};
                    inputs.forEach(input => {
                        if (input.classList.length > 0) {
                            obj[input.classList[0]] = input.value;
                        }
                    });
                    jsonField.value = JSON.stringify(obj);
                });
            }
        });
    </script>
</x-app-layout>
