<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Data Perbandingan Kriteria') }}
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

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Daftar Perbandingan Kriteria</h2>
        </div>

        <form action="{{ route('perbandingankriteria.store') }}" method="POST" class="mb-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="kriteria_1" class="block font-semibold">Kriteria 1</label>
                    <select name="kriteria_1" class="w-full border-gray-300 rounded-lg p-2" required>
                        <option value="">-- Pilih Kriteria --</option>
                        @foreach($kriterias as $kriteria)
                            <option value="{{ $kriteria->id }}">{{ $kriteria->nama_kriteria }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="nilai" class="block font-semibold">Nilai Perbandingan</label>
                    <input type="number" name="nilai" step="0.01" min="0.1" max="9" class="w-full border-gray-300 rounded-lg p-2" required>
                </div>
                <div>
                    <label for="kriteria_2" class="block font-semibold">Kriteria 2</label>
                    <select name="kriteria_2" class="w-full border-gray-300 rounded-lg p-2" required>
                        <option value="">-- Pilih Kriteria --</option>
                        @foreach($kriterias as $kriteria)
                            <option value="{{ $kriteria->id }}">{{ $kriteria->nama_kriteria }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600">Simpan Perbandingan</button>
        </form>

        <h3 class="text-lg font-semibold mt-6">Matriks Perbandingan</h3>
        <table class="w-full border text-center mt-2">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Kriteria</th>
                    @foreach($kriterias as $kriteria)
                        <th class="border p-2">{{ $kriteria->nama_kriteria }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($matrix as $rowIndex => $row)
                    <tr>
                        <th class="border p-2">{{ $kriterias->where('id', $rowIndex)->first()->nama_kriteria }}</th>
                        @foreach($row as $value)
                            <td class="border p-2">{{ number_format($value, 2) }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="text-lg font-semibold mt-6">Matriks Normalisasi & Eigen Vector</h3>
        <table class="w-full border text-center mt-2">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Kriteria</th>
                    @foreach($kriterias as $kriteria)
                        <th class="border p-2">{{ $kriteria->nama_kriteria }}</th>
                    @endforeach
                    <th class="border p-2">Eigen Vector</th>
                </tr>
            </thead>
            <tbody>
                @foreach($normalizedMatrix as $rowIndex => $row)
                    <tr>
                        <th class="border p-2">{{ $kriterias->where('id', $rowIndex)->first()->nama_kriteria }}</th>
                        @foreach($row as $value)
                            <td class="border p-2">{{ number_format($value, 6) }}</td>
                        @endforeach
                        <td class="border p-2 font-bold">{{ number_format($eigenVector[$rowIndex], 6) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="text-lg font-semibold mt-6">Analisis Konsistensi</h3>
        <table class="w-full border text-left mt-2">
            <tr>
                <th class="border p-2">λ Maksimum (λmax)</th>
                <td class="border p-2">{{ number_format($lambdaMax, 6) }}</td>
            </tr>
            <tr>
                <th class="border p-2">Consistency Index (CI)</th>
                <td class="border p-2">{{ number_format($CI, 6) }}</td>
            </tr>
            <tr>
                <th class="border p-2">Consistency Ratio (CR)</th>
                <td class="border p-2">{{ number_format($CR, 6) }}</td>
            </tr>
        </table>

        @if($CR < 0.1)
            <div class="bg-green-100 text-green-700 p-3 mt-4 rounded">Perbandingan <strong>konsisten</strong> (CR < 0.1).</div>
        @else
            <div class="bg-red-100 text-red-700 p-3 mt-4 rounded">Perbandingan <strong>tidak konsisten</strong> (CR >= 0.1).</div>
        @endif
    </div>
    </div>
    </div>
</x-app-layout>
