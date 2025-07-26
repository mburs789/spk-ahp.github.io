<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Tambah Penilaian') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-800 shadow-lg rounded-2xl p-6 border border-gray-200">

                <form action="{{ route('penilaian.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="karyawan_id" class="block text-lg font-semibold text-gray-700 mb-2">Pilih Karyawan</label>
                        <select name="karyawan_id" id="karyawan_id" class="border border-gray-300 rounded-lg px-4 py-2 w-1/2 focus:ring-2 focus:ring-blue-300 text-lg" required>
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($karyawans as $karyawan)
                                <option value="{{ $karyawan->id }}">{{ $karyawan->nama_karyawan }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="overflow-x-auto rounded-lg shadow-md">
                        <table class="w-full border-collapse bg-white shadow-md rounded-lg text-center">
                            <thead class="bg-gray-200 text-gray-800">
                                <tr>
                                    <th class="px-4 py-2 border">Kriteria</th>
                                    <th class="px-4 py-2 border">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kriterias as $kriteria)
                                <tr class="hover:bg-gray-100 transition-all">
                                    <td class="px-4 py-2 border text-lg">{{ $kriteria->nama_kriteria }}</td>
                                    <td class="px-4 py-2 border">
                                        <input type="number" step="0.1" min="0" max="10" 
                                               name="nilai[{{ $kriteria->id }}]" 
                                               class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-blue-300 text-lg" required>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="px-3 py-1 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-200">Simpan</button>
                        <a href="{{ route('penilaian.index') }}" class="px-3 py-1 bg-gray-500 text-white font-semibold rounded-lg shadow-md hover:bg-gray-600 transition duration-200">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
