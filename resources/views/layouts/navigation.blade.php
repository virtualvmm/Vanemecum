@php
    $unreadMensajes = auth()->check() && auth()->user()->hasRole('Admin')
        ? \App\Models\ContactMessage::where('leido', false)->count()
        : 0;
@endphp
<nav x-data="{ open: false }" class="bg-indigo-50 border-b border-indigo-100 dark:bg-indigo-950/40 dark:border-indigo-800/50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <x-application-logo class="block h-14 sm:h-16 lg:h-20 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Bienvenido') }}
                    </x-nav-link>

                    {{-- AÑADIMOS ESTOS ENLACES CLAVE --}}
                    @admin
                        <x-nav-link :href="route('patogenos.index')" :active="request()->routeIs('patogenos.*')">
                            {{ __('Micro-DB (Patógenos)') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.alertas.index')" :active="request()->routeIs('admin.alertas.*')">
                            {{ __('Alertas') }}
                        </x-nav-link>
                    @endadmin
                    <x-nav-link :href="route('tratamientos.index')" :active="request()->routeIs('tratamientos.index')">
                        {{ __('Tratamientos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('guia.index')" :active="request()->routeIs('guia.index')">
                        {{ __('Guía Rápida') }}
                    </x-nav-link>
                    <x-nav-link :href="route('favoritos.index')" :active="request()->routeIs('favoritos.*')">
                        {{ __('Mis patógenos') }}
                    </x-nav-link>
                    @admin
                        <x-nav-link :href="route('admin.mensajes.index')" :active="request()->routeIs('admin.mensajes.*')" class="inline-flex items-center gap-1.5">
                            {{ __('Mensajes') }}
                            @if ($unreadMensajes > 0)
                                <span class="inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1.5 text-xs font-bold text-white bg-red-500 rounded-full" title="{{ $unreadMensajes }} sin leer">
                                    {{ $unreadMensajes > 99 ? '99+' : $unreadMensajes }}
                                </span>
                            @endif
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('contact.create')" :active="request()->routeIs('contact.*')">
                            {{ __('Contactar') }}
                        </x-nav-link>
                    @endadmin
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-indigo-200/50 dark:border-indigo-700/50 text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-indigo-100/50 dark:bg-indigo-900/30 hover:bg-indigo-100 dark:hover:bg-indigo-800/50 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-800/50 focus:outline-none focus:bg-indigo-100 dark:focus:bg-indigo-800/50 focus:text-gray-800 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Bienvenido') }}
            </x-responsive-nav-link>

             {{-- AÑADIMOS ESTOS ENLACES CLAVE --}}
            @admin
            <x-responsive-nav-link :href="route('patogenos.index')" :active="request()->routeIs('patogenos.*')">
                {{ __('Micro-DB (Patógenos)') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.alertas.index')" :active="request()->routeIs('admin.alertas.*')">
                {{ __('Alertas') }}
            </x-responsive-nav-link>
            @endadmin
            <x-responsive-nav-link :href="route('tratamientos.index')" :active="request()->routeIs('tratamientos.index')">
                {{ __('Tratamientos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('guia.index')" :active="request()->routeIs('guia.index')">
                {{ __('Guía Rápida') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('favoritos.index')" :active="request()->routeIs('favoritos.*')">
                {{ __('Mis patógenos') }}
            </x-responsive-nav-link>
            @admin
                <x-responsive-nav-link :href="route('admin.mensajes.index')" :active="request()->routeIs('admin.mensajes.*')">
                    <span class="inline-flex items-center gap-2">
                        {{ __('Mensajes') }}
                        @if ($unreadMensajes > 0)
                            <span class="inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1.5 text-xs font-bold text-white bg-red-500 rounded-full">
                                {{ $unreadMensajes > 99 ? '99+' : $unreadMensajes }}
                            </span>
                        @endif
                    </span>
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('contact.create')" :active="request()->routeIs('contact.*')">
                    {{ __('Contactar') }}
                </x-responsive-nav-link>
            @endadmin
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-indigo-200 dark:border-indigo-800">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>