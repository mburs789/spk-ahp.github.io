<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Tambah Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-800 shadow-lg rounded-2xl p-6 border border-gray-200">
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 border border-red-300 shadow-md">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('kriteria.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Kode Kriteria</label>
                        <input type="text" name="kode_kriteria" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-300" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-300" required>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-lg shadow hover:bg-blue-700 transition-all">Tambah</button>
                        <a href="{{ route('kriteria.index') }}" class="bg-gray-500 text-white px-3 py-1 rounded-lg shadow hover:bg-gray-600 transition-all">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
