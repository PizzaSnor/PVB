
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo size="180" />
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('occasions.home')" :active="request()->routeIs('occasions.home')">
                        {{ __('Occasions') }}
                    </x-nav-link>
                    <x-nav-link :href="route('service.create')" :active="request()->routeIs('service.create')">
                        {{ __('Service') }}
                    </x-nav-link>
                    <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                        {{ __('Contact') }}
                    </x-nav-link>
                    @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        @else
                        <a href="{{ route('login') }}" class="font-semibold text-black hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-yellow">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-black hover:text-gray-900  focus:outline focus:outline-2 focus:rounded-sm focus:outline-yellow">Registreer</a>
                        @endif
                    @endauth
                </div>
            @endif
                </div>
            </div>
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @auth
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-xl leading-4 font-semibold rounded-md text-black bg-orange hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                 <div class="text-md"><span class="text-md font-medium">Welkom,</span>
                                    {{ Auth::user()->name }}</div>


                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                            @endauth

                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profiel') }}
                            </x-dropdown-link>
                            @auth
                                @if (Auth::user()->isAdminOrMechanic())
                                    <x-dropdown-link :href="route('dashboard.service.index')">
                                        {{ __('Beheren') }}
                                    </x-dropdown-link>
                                @endcan

                            @endauth
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Uitloggen') }}
                                </x-dropdown-link>
                            </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-black focus:outline-none  transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="black" fill="none" viewBox="0 0 24 24">
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
            @guest
            <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                {{ __('Login') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                {{ __('Registreer') }}
            </x-responsive-nav-link>
            @endguest
            <x-responsive-nav-link :href="route('occasions.home')" :active="request()->routeIs('occasions.home')">
                {{ __('Occasions') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('service.create')" :active="request()->routeIs('service.create')">
                {{ __('Service') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                {{ __('Contact') }}
            </x-responsive-nav-link>
            @auth
                @if (Auth::user()->isAdminOrMechanic())
                    <x-responsive-nav-link :href="route('dashboard.users.index')" :active="request()->routeIs('dashboard.service.index')">
                        {{ __('Beheren') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-semibold text-xl text-black">{{ Auth::user()->name }}</div>
                    <div class="font-semibold text-xl text-black">{{ Auth::user()->email }}</div>
                </div>
            @endauth
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profiel') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Uitloggen') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

</nav>
