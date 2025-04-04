@php
    use Illuminate\Support\Facades\Auth;
    $navClass = 'border-b border-gray-100 dark:border-gray-700 dark:bg-gray-800';
    $style = '';
    if (Auth::user()->bedrijf && Auth::user()->bedrijf->huisstijl) {
        $style = 'background-color: ' . Auth::user()->bedrijf->huisstijl . ';';
    } else {
        $navClass .= ' bg-white';
    }
@endphp

    @if(Auth::user()->bedrijf)
    <nav class="bg-{{ Auth::user()->bedrijf->huisstijl }}-500 dark:bg-gray-800">
        @else
    <nav class="bg-white dark:bg-gray-800">
        @endif
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/Logo.png') }}"
                             class="block w-[150px] h-auto fill-current text-gray-800 dark:text-gray-200"
                             alt="Application Logo"/>
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('advertenties.index')" :active="request()->routeIs('advertenties')">
                        {{ __('Advertenties') }}
                    </x-nav-link>
                    <x-nav-link :href="route('verhuuradvertenties.index')"
                                :active="request()->routeIs('verhuuradvertenties')">
                        {{ __('Verhuuradvertenties') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 relative">
                @auth
                    <input type="checkbox" id="dropdown-toggle" class="hidden peer">
                    <label for="dropdown-toggle"
                           class="inline-flex items-center px-2 py-1 border text-sm leading-4 font-medium rounded-md text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out cursor-pointer">
                        <div class="truncate max-w-[120px]">{{ Auth::user()->name }}</div>
                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </label>
                    <!-- Dropdown Content -->
                    <div
                        class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden peer-checked:block">
                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Profile') }}
                        </a>
                        <!-- bedrijf -->
                        @if (Auth::user()->bedrijf)
                            <a href="{{ route('bedrijf.edit', ['id' => Auth::user()->bedrijf->id]) }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ __('Bedrijfs profiel') }}
                            </a>
                        @endif
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                @endauth
            </div>

            <!-- Hamburger Menu -->
            <div class="sm:hidden flex items-center">
                <input type="checkbox" id="hamburger-toggle" class="hidden peer">
                <label for="hamburger-toggle" class="-mr-2 flex items-center cursor-pointer">
                    <button
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </label>
                <!-- Mobile Menu -->
                <div
                    class="absolute right-0 top-full mt-2 w-48 bg-white shadow-md border border-gray-200 rounded-md hidden peer-checked:block">
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('advertenties.index')"
                                           :active="request()->routeIs('advertenties')">
                        {{ __('Advertenties') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('verhuuradvertenties.index')"
                                           :active="request()->routeIs('verhuuradvertenties')">
                        {{ __('Verhuuradvertenties') }}
                    </x-responsive-nav-link>

                    @auth
                        <!-- Responsive Settings Options -->
                        <div class="pt-2 pb-1 border-t border-gray-200 dark:border-gray-600">
                            <div class="px-3">
                                <div
                                    class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                            <div class="mt-2 space-y-0.5">
                                <x-responsive-nav-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-responsive-nav-link>
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-responsive-nav-link :href="route('logout')"
                                                           onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-responsive-nav-link>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>
