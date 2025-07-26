<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Tambah Subkriteria') }}
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

        <form action="{{ route('subkriteria.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Pilihan Kriteria -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Kriteria</label>
                <select name="kriteria_id" class="w-full border-gray-300 rounded-lg px-3 py-2 text-gray-700 focus:ring-2 focus:ring-blue-300">
                    <option value="">-- Pilih Kriteria --</option>
                    @foreach($kriterias as $kriteria)
                        <option value="{{ $kriteria->id }}">{{ $kriteria->nama_kriteria }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Kode Subkriteria -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Kode Subkriteria</label>
                <input type="text" name="kode_subkriteria" class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300" required>
            </div>

            <!-- Nama Subkriteria -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Subkriteria</label>
                <input type="text" name="nama_subkriteria" class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300" required>
            </div>

            <!-- Nilai Minimum -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nilai Minimum</label>
                <input type="number" step="0.1" min="0" max="10" name="nilai_min" id="nilai_min"
                       class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300" required>
            </div>

            <!-- Nilai Maksimum -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nilai Maksimum</label>
                <input type="number" step="0.1" min="0" max="10" name="nilai_max" id="nilai_max"
                       class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300" required>
            </div>

            <!-- Tombol Simpan & Batal -->
            <div class="flex justify-end space-x-3">
                <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Tambah
                </button>
                <a href="{{ route('subkriteria.index') }}" class="px-3 py-1 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    Batal
                </a>
            </div>
        </form>
    </div>
    </div>
    </div>
</x-app-layout>
