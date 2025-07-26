<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Data Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-800 shadow-lg rounded-2xl p-6 border border-gray-200">
                @if (session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 border border-green-300 shadow-md">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-6">
                    <h2 class="text-xl font-semibold">Daftar Kriteria</h2>
                </div>
                <div class="mb-6 text-right">
                    <a href="{{ route('kriteria.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition-all">Tambah Kriteria</a>
                </div>

                <div class="overflow-x-auto rounded-lg shadow-md">
                    <table class="w-full border-collapse bg-white shadow-md rounded-lg text-center">
                        <thead class="bg-gray-200 text-gray-800">
                            <tr>
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">Nama Kriteria</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($kriterias->isEmpty())
                                <tr>
                                    <td colspan="4" class="px-4 py-2 border text-gray-600">Data kriteria tidak ditemukan.</td>
                                </tr>
                            @else
                                @foreach ($kriterias as $index => $kriteria)
                                    <tr class="hover:bg-gray-100 transition-all">
                                        <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 border">{{ $kriteria->nama_kriteria }}</td>
                                        <td class="px-4 py-2 border flex justify-center space-x-2">
                                            <a href="{{ route('kriteria.edit', $kriteria->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow hover:bg-yellow-600 transition-all">Edit</a>
                                            <form action="{{ route('kriteria.destroy', $kriteria->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg shadow hover:bg-red-600 transition-all">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- <div class="mt-6 flex justify-end mb-6">
                    <a href="{{ url()->previous() }}" class="bg-gray-500 text-white px-3 py-1 rounded-lg shadow hover:bg-gray-600 transition-all">Kembali</a>
                </div> --}}
            </div>
        </div>
    </div>
</x-app-layout>
