<nav x-data="{ open: false }" class="bg-blue-600 border-b shadow-md w-full">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo lebih ke kiri -->
            <div class="flex items-center ml-4">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10 w-auto">
                    <span class="ml-3 text-xl font-semibold text-white">PT. Unilab Perdana</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:flex space-x-8 flex-1 justify-center">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                    class="text-white hover:text-gray-200 px-3 py-2 {{ request()->routeIs('dashboard') ? 'border-b-2 border-white' : '' }}">
                    {{ __('Dashboard') }}
                </x-nav-link>
                @auth

                @role('admin')
                    <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.*')"
                        class="text-white hover:text-gray-200 px-3 py-2 {{ request()->routeIs('user.*') ? 'border-b-2 border-white' : '' }}">
                        {{ __('User') }}
                    </x-nav-link>
                @endrole

                @role('admin|supervisor')
                    <x-nav-link :href="route('karyawan.index')" :active="request()->routeIs('karyawan.*')"
                        class="text-white hover:text-gray-200 px-3 py-2 {{ request()->routeIs('karyawan.*') ? 'border-b-2 border-white' : '' }}">
                        {{ __('Karyawan') }}
                    </x-nav-link>

                    <x-nav-link :href="route('kriteria.index')" :active="request()->routeIs('kriteria.*')"
                        class="text-white hover:text-gray-200 px-3 py-2 {{ request()->routeIs('kriteria.*') ? 'border-b-2 border-white' : '' }}">
                        {{ __('Kriteria') }}
                    </x-nav-link>

                    <x-nav-link :href="route('subkriteria.index')" :active="request()->routeIs('subkriteria.*')"
                        class="text-white hover:text-gray-200 px-3 py-2 {{ request()->routeIs('subkriteria.*') ? 'border-b-2 border-white' : '' }}">
                        {{ __('Subkriteria') }}
                    </x-nav-link>

                    <!-- Dropdown Perbandingan -->
                    <div class="relative" @click.away="open = false">
                        <button @click="open = ! open"
                            class="flex items-center px-3 py-2 text-white hover:text-gray-200 focus:outline-none transition 
                            {{ request()->routeIs('perbandingankriteria.*') || request()->routeIs('perbandingansubkriteria.*') ? 'border-b-2 border-white' : '' }}">
                            <span class="mr-2">Perbandingan</span>
                            <svg class="w-4 h-4 text-white hover:text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Items -->
                        <div x-show="open" @click.stop class="absolute z-50 mt-2 w-48 bg-white border rounded-md shadow-md">
                            <x-nav-link :href="route('perbandingankriteria.index')" :active="request()->routeIs('perbandingankriteria.*')"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('perbandingankriteria.*') ? 'font-semibold text-blue-600' : '' }}">
                                {{ __('Perbandingan Kriteria') }}
                            </x-nav-link>

                            <x-nav-link :href="route('perbandingansubkriteria.index', ['kriteria_id' => 1])" :active="request()->routeIs('perbandingansubkriteria.*')"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('perbandingansubkriteria.*') ? 'font-semibold text-blue-600' : '' }}">
                                {{ __('Perbandingan Subkriteria') }}
                            </x-nav-link>
                        </div>
                    </div>

                    <x-nav-link :href="route('penilaian.index')" :active="request()->routeIs('penilaian.*')"
                        class="text-white hover:text-gray-200 px-3 py-2 {{ request()->routeIs('penilaian.*') ? 'border-b-2 border-white' : '' }}">
                        {{ __('Penilaian') }}
                    </x-nav-link>
                @endrole

                @role('admin|manager')
                    <x-nav-link :href="route('perangkingan.index')" :active="request()->routeIs('perangkingan.index')"
                        class="text-white hover:text-gray-200 px-3 py-2 {{ request()->routeIs('perangkingan.index') ? 'border-b-2 border-white' : '' }}">
                        {{ __('Perangkingan') }}
                    </x-nav-link>
                @endrole
                @endauth
            </div>

            <!-- Settings Dropdown lebih ke kanan -->
            @auth
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center px-4 py-2 text-white hover:text-gray-200">
                    <span class="mr-2">{{ Auth::user()->name }}</span>
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            
                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Log Out</button>
                    </form>
                </div>
            </div>
            
            @endauth
        </div>
    </div>
</nav>
