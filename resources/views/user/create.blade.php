<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Tambah User') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-800 shadow-lg rounded-2xl p-6 border border-gray-200">
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="name" name="name" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300">
                    </div>
    
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300">
                    </div>
    
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300">
                    </div>
    
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300">
                    </div>
    
                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700">Peran</label>
                        <select id="role" name="role" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300">
                            <option value="">-- Pilih Peran --</option>
                            <option value="admin">Admin</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="manager">Manager</option>
                        </select>
                    </div>
    
                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition-all">
                            Tambah
                        </button>
                        <a href="{{ route('user.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600 transition-all">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>