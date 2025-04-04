<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow-md mt-10">

        <h1 class="text-2xl font-bold text-gray-900 mb-6">
            Importeer {{ $type === 'verhuur' ? 'Verhuuradvertenties' : 'Advertenties' }} via CSV
        </h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('advertenties.csvimport.store', ['type' => $type]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="csv_file" class="block text-gray-700 font-medium mb-2">Kies CSV-bestand</label>
                <input type="file" name="csv_file" id="csv_file" accept=".csv,.txt" required
                       class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-md transition duration-200">
                Importeren
            </button>
        </form>

    </div>
</x-app-layout>
