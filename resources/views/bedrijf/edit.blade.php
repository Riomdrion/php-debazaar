<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-2xl font-semibold mb-6">Bedrijf bewerken: {{ $bedrijf->naam }}</h1>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('bedrijf.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <input type="hidden" name="id" value="{{ $bedrijf->id }}">


            {{-- Naam --}}
            <div>
                <label for="naam" class="block text-sm font-medium text-gray-700 mb-1">
                    Naam
                </label>
                <input
                    type="text"
                    id="naam"
                    name="naam"
                    required
                    value="{{ old('naam', $bedrijf->naam) }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                        @error('naam') border-red-500 @enderror"
                />
                @error('naam')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">
                    Slug
                </label>
                <input
                    type="text"
                    id="slug"
                    name="slug"
                    required
                    value="{{ old('slug', $bedrijf->slug) }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                        @error('slug') border-red-500 @enderror"
                />
                @error('slug')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Huisstijl --}}
            <div>
                <label for="hs-color-input" class="block text-sm font-medium mb-2 dark:text-white">Color picker</label>
                <input type="color"
                       class="p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700"
                       id="hs-color-input" name="huisstijl" value="{{ old('huisstijl', $bedrijf->huisstijl) }}"
                       title="Choose your color">
                @error('huisstijl')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            {{-- Logo --}}
            {{-- Submit button --}}
            <div>
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md
                           font-semibold text-white tracking-widest hover:bg-indigo-700 focus:outline-none
                           focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Opslaan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
