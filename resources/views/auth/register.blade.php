<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- User Type -->
        <div class="mt-4">
            <x-input-label for="user_type" :value="__('Type')" />
            <select id="user_type" name="user_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" onchange="showCompanyFields()">
                <option value="klant" {{ old('user_type') == 'klant' ? 'selected' : '' }}>{{ __('Klant') }}</option>
                <option value="particulier" {{ old('user_type') == 'particulier' ? 'selected' : '' }}>{{ __('Particulier (advertensies)') }}</option>
                <option value="bedrijf" {{ old('user_type') == 'bedrijf' ? 'selected' : '' }}>{{ __('Bedrijf') }}</option>
            </select>
            <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
        </div>

        <!-- Company Name and slug -->
        <div id="company_fields" class="mt-4" style="display: none;">
            <x-input-label for="company_name" :value="__('Company Name')" />
            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" autocomplete="organization" />
            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />

            <x-input-label for="slug" :value="__('slug')" class="mt-4" />
            <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug')" autocomplete="url" />
            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function showCompanyFields() {
            const userType = document.getElementById('user_type').value;
            const companyFields = document.getElementById('company_fields');
            if (userType === 'bedrijf') {
                companyFields.style.display = 'block';
            } else {
                companyFields.style.display = 'none';
            }
        }

        // Initial load check
        document.addEventListener('DOMContentLoaded', function() {
            showCompanyFields();
        });
    </script>
</x-guest-layout>
