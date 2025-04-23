<nav x-data="{ open: false }" class="bg-white border-b border-electric-orange-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-electric-orange-500 font-bold text-xl">
                        <x-application-logo class="block h-9 w-auto fill-current" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('tenants')" :active="request()->routeIs('tenants')" wire:navigate>
                        {{ __('Tenants') }}
                    </x-nav-link>

                    <x-nav-link :href="route('control-panel')" :active="request()->routeIs('control-panel')" wire:navigate>
                        {{ __('Control Panel') }}
                    </x-nav-link>

                    <x-nav-link :href="route('visual-data')" :active="request()->routeIs('visual-data') || request()->routeIs('visual-data.room')" wire:navigate>
                        {{ __('Visual Data') }}
                    </x-nav-link>

                    <x-nav-link :href="route('watt-ai')" :active="request()->routeIs('watt-ai')">
                        {{ __('Watt AI') }}
                    </x-nav-link>

                    {{-- <x-nav-link :href="route('menu2')" :active="request()->routeIs('menu2')">
                        {{ __('Menu2') }}
                    </x-nav-link>

                    <x-nav-link :href="route('menu3')" :active="request()->routeIs('menu3')">
                        {{ __('Menu3') }}
                    </x-nav-link> --}}
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-electric-orange-600 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:text-electric-orange-600">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                class="hover:text-electric-orange-600">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-electric-orange-500 hover:bg-electric-orange-50 focus:outline-none focus:bg-electric-orange-50 focus:text-electric-orange-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="hover:text-electric-orange-600 hover:bg-electric-orange-50">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('tenants')" :active="request()->routeIs('tenants')"
                class="hover:text-electric-orange-600 hover:bg-electric-orange-50">
                {{ __('Tenants') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('control-panel')" :active="request()->routeIs('control-panel')"
                class="hover:text-electric-orange-600 hover:bg-electric-orange-50">
                {{ __('Control Panel') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('visual-data')" :active="request()->routeIs('visual-data') || request()->routeIs('visual-data.room')"
                class="hover:text-electric-orange-600 hover:bg-electric-orange-50">
                {{ __('Visual Data') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('watt-ai')" :active="request()->routeIs('watt-ai')">
                {{ __('Watt AI') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-electric-orange-100">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')"
                    class="hover:text-electric-orange-600 hover:bg-electric-orange-50">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();"
                        class="hover:text-electric-orange-600 hover:bg-electric-orange-50">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
