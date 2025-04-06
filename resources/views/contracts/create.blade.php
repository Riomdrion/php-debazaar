<x-app-layout>
    <!-- Groene pop-up (verborgen standaard) -->
    <div id="successPopup" class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded-md shadow-lg z-50 flex items-center hidden">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span id="successMessage">Contract is succesvol verstuurd!</span>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form id="contractForm" action="{{ route('contracts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="bedrijf_id" value="{{ $bedrijf->id }}">
                <input type="hidden" name="is_goedgekeurd" value="0">

                <!-- Titel -->
                <div>
                    <label for="titel" class="block text-sm font-medium text-gray-700">Titel</label>
                    <input type="text" name="titel" id="titel" required
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>

                <!-- Prijs -->
                <div>
                    <label for="prijs" class="block text-sm font-medium text-gray-700">Prijs</label>
                    <input type="number" step="0.01" name="prijs" id="prijs" required
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>

                <!-- Factuur -->
                <div>
                    <label for="factuur" class="block text-sm font-medium text-gray-700">Factuur (PDF)</label>
                    <input type="file" name="factuur" id="factuur" accept=".pdf" required
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Maak Contract
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('contractForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const popup = document.getElementById('successPopup');
            const successMessage = document.getElementById('successMessage');

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok');
                })
                .then(data => {
                    // Update bericht indien nodig
                    if (data.message) {
                        successMessage.textContent = data.message;
                    }

                    // Toon pop-up
                    popup.classList.remove('hidden');

                    // Verberg na 3 seconden en redirect
                    setTimeout(() => {
                        popup.classList.add('hidden');
                        window.location.href = "{{ route('admin.bedrijven.zonder.factuur') }}";
                    }, 1000);

                    // Reset formulier (optioneel)
                    this.reset();
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Hier kun je eventueel een foutmelding tonen
                });
        });
    </script>
</x-app-layout>
