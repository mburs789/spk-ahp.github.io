<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Edit Penilaian') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-800 shadow-lg rounded-2xl p-6 border border-gray-200">

                <form action="{{ route('penilaian.update', $penilaian->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-lg font-semibold text-gray-700 mb-2">Karyawan</label>
                        <input type="text" class="border border-gray-300 rounded-lg px-4 py-2 w-full bg-gray-100 text-lg" value="{{ $penilaian->karyawan->nama_karyawan }}" disabled>
                    </div>

                    <div>
                        <label class="block text-lg font-semibold text-gray-700 mb-2">Kriteria</label>
                        <input type="text" class="border border-gray-300 rounded-lg px-4 py-2 w-full bg-gray-100 text-lg" value="{{ $penilaian->kriteria->nama_kriteria }}" disabled>
                    </div>

                    <div>
                        <label for="nilai" class="block text-lg font-semibold text-gray-700 mb-2">Nilai</label>
                        <input type="number" name="nilai" step="0.1" min="0" max="10" 
                               class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-blue-300 text-lg" 
                               value="{{ $penilaian->nilai }}" required>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="px-3 py-1 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-200">Simpan Perubahan</button>
                        <a href="{{ route('penilaian.index') }}" class="px-3 py-1 bg-gray-500 text-white font-semibold rounded-lg shadow-md hover:bg-gray-600 transition duration-200">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
