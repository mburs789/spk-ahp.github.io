<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200">
              
                @if (session('status'))
                    <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 border border-green-300 shadow-md">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Header Informasi Pengguna -->
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-800">Informasi Pengguna Saat Ini</h3>
                </div>

                <!-- Tabel Informasi Pengguna -->
                <div class="overflow-x-auto mb-6">
                    <table class="w-full border-collapse border border-gray-200 rounded-lg">
                        <tbody>
                            <tr class="border-b">
                                <td class="px-6 py-3 text-gray-600 font-medium w-1/3">Nama</td>
                                <td class="px-6 py-3 text-gray-600 font-medium w-1">:</td>
                                <td class="px-6 py-3 text-gray-900 font-semibold">{{ Auth::user()->name }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="px-6 py-3 text-gray-600 font-medium">Email</td>
                                <td class="px-6 py-3 text-gray-600 font-medium w-1">:</td>
                                <td class="px-6 py-3 text-gray-900 font-semibold">{{ Auth::user()->email }}</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3 text-gray-600 font-medium">Peran</td>
                                <td class="px-6 py-3 text-gray-600 font-medium w-1">:</td>
                                <td class="px-6 py-3 text-gray-900 font-semibold capitalize">
                                    {{ Auth::user()->roles->pluck('name')->first() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Semua Form Profil dalam Satu Container -->
                <div class="space-y-6">
                    <div class="p-4 sm:p-6 bg-gray-50 shadow-inner rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Update Informasi</h3>
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div class="p-4 sm:p-6 bg-gray-50 shadow-inner rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Ubah Password</h3>
                        @include('profile.partials.update-password-form')
                    </div>

                    <div class="p-4 sm:p-6 bg-red-50 border border-red-200 shadow-inner rounded-lg">
                        <h3 class="text-lg font-semibold text-red-800 mb-3">Hapus Akun</h3>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
