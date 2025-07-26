<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Data Subkriteria') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-800 shadow-lg rounded-2xl p-6 border border-gray-200">
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 border border-green-300 shadow-md">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold">Daftar Subkriteria</h2>
                </div>

                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <label for="filter_kriteria" class="text-gray-700 font-semibold">Pilih Kriteria:</label>
                        <select id="filter_kriteria" class="border border-gray-300 rounded-lg px-3 py-2 min-w-[250px]  focus:ring-2 focus:ring-blue-300" onchange="filterKriteria()"> 
                            <option value="">-- Pilih Kriteria --</option>
                                @foreach($kriterias as $kriteria)
                                <option value="{{ $kriteria->id }}" {{ $kriteria_id == $kriteria->id ? 'selected' : '' }}>
                                    {{ $kriteria->nama_kriteria }}
                                </option>
                                @endforeach
                        </select>
                    </div>
                    <a href="{{ route('subkriteria.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded-lg shadow hover:bg-blue-700 transition-all">Tambah Subkriteria</a>
                </div>
                
                <div class="overflow-x-auto rounded-lg shadow-md">
                    <table class="w-full border-collapse bg-white shadow-md rounded-lg text-center">
                        <thead class="bg-gray-200 text-gray-800">
                            <tr>
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">Kode Subkriteria</th>
                                <th class="px-4 py-2 border">Nama Subkriteria</th>
                                <th class="px-4 py-2 border">Nilai Min</th>
                                <th class="px-4 py-2 border">Nilai Max</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subkriterias as $index => $subkriteria)
                            <tr class="hover:bg-gray-100 transition-all">
                                <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border">{{ $subkriteria->kode_subkriteria }}</td>
                                <td class="px-4 py-2 border">{{ $subkriteria->nama_subkriteria }}</td>
                                <td class="px-4 py-2 border">{{ $subkriteria->nilai_min }}</td>
                                <td class="px-4 py-2 border">{{ $subkriteria->nilai_max }}</td>
                                <td class="px-4 py-2 border flex justify-center space-x-2">
                                    <a href="{{ route('subkriteria.edit', $subkriteria->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow hover:bg-yellow-600 transition-all">Edit</a>
                                    <form action="{{ route('subkriteria.destroy', $subkriteria->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus subkriteria ini?')">
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

    <script>
        function filterKriteria() {
            var kriteriaId = document.getElementById('filter_kriteria').value;
            window.location.href = "{{ route('subkriteria.index') }}?kriteria_id=" + kriteriaId;
        }
    </script>
</x-app-layout>