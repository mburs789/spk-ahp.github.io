<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Data Penilaian') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-800 shadow-lg rounded-2xl p-6 border border-gray-200">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-800 shadow-lg rounded-2xl p-6 border border-gray-200">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold">Daftar Penilaian</h2>
                </div>
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <form method="GET" action="{{ route('penilaian.index') }}">
                            <label for="karyawan_id" class="text-gray-700 font-semibold">Pilih Karyawan:</label>
                            <select name="karyawan_id" id="karyawan_id" class="border border-gray-300 rounded-lg px-3 py-2 min-w-[250px]  focus:ring-2 focus:ring-blue-300" onchange="this.form.submit()">
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id }}" {{ $selectedKaryawan == $karyawan->id ? 'selected' : '' }}>
                                        {{ $karyawan->nama_karyawan }} <!-- Tampilkan nama karyawan disini -->
                                    </option>
                                @endforeach
                            </select>
                        </form>                    
                    </div>
                
                    <!-- Tombol Input Penilaian di sebelah kanan -->
                    <a href="{{ route('penilaian.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded-lg shadow hover:bg-blue-700 transition-all">
                        Input Penilaian
                    </a>
                </div>
                
                
                <div class="overflow-x-auto rounded-lg shadow-md">
                    <table class="w-full border-collapse bg-white shadow-md rounded-lg text-center">
                        <thead class="bg-gray-200 text-gray-800">
                            <tr>
                                <th class="px-4 py-2 border">Kriteria</th>
                                <th class="px-4 py-2 border">Subkriteria</th>
                                <th class="px-4 py-2 border">Nilai</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penilaians as $penilaian)
                                <tr class="hover:bg-gray-100 transition-all">
                                    <td class="px-4 py-2 border text-lg">{{ $penilaian->subkriteria->kriteria->nama_kriteria }}</td>
                                    <td class="px-4 py-2 border text-lg">{{ $penilaian->subkriteria->nama_subkriteria }}</td>
                                    <td class="px-4 py-2 border text-lg font-semibold">{{ $penilaian->nilai }}</td>
                                    <td class="px-4 py-2 border flex justify-center space-x-2">
                                        <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow hover:bg-yellow-600 transition-all">Edit</a>
                                        <form action="{{ route('penilaian.destroy', $penilaian->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus penilaian ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg shadow hover:bg-red-600 transition-all">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
