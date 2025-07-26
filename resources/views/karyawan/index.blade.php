<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Data Karyawan') }}
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

                <!-- Judul Daftar Karyawan -->
                <h2 class="text-xl font-semibold mb-4">Daftar Karyawan</h2>

                <!-- Filter, Pencarian, dan Tombol Tambah -->
                <div class="flex justify-between items-center mb-6">
                    <form method="GET" class="flex space-x-2">
                        <input type="text" id="searchInput" placeholder="Cari NIK / Nama..." 
                            class="border rounded-lg px-3 py-1 focus:ring-2 focus:ring-blue-300">
                        
                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-lg shadow hover:bg-blue-700 transition-all">
                            Cari
                        </button>
                    </form>

                    <a href="{{ route('karyawan.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded-lg shadow hover:bg-blue-700 transition-all">
                        Tambah Karyawan
                    </a>
                </div>

                <!-- Tabel Karyawan -->
                <div class="overflow-x-auto rounded-lg shadow-md">
                    <table class="w-full border-collapse bg-white shadow-md rounded-lg text-center">
                        <thead class="bg-gray-200 text-gray-800">
                            <tr>
                                <th class="px-4 py-3 border">No</th>
                                <th class="px-4 py-3 border">NIK</th>
                                <th class="px-4 py-3 border">Nama Karyawan</th>
                                <th class="px-4 py-3 border">Jabatan</th>
                                <th class="px-4 py-3 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="karyawanTable">
                            @forelse ($karyawans as $index => $karyawan)
                            <tr class="hover:bg-gray-100 transition-all">
                                <td class="px-4 py-3 border">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 border karyawan-nik">{{ $karyawan->nik }}</td>
                                <td class="px-4 py-3 border karyawan-name">{{ $karyawan->nama_karyawan }}</td>
                                <td class="px-4 py-3 border">{{ $karyawan->jabatan }}</td>
                                <td class="px-4 py-3 border flex justify-center space-x-2">
                                    <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow hover:bg-yellow-600 transition-all">Edit</a>
                                    <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg shadow hover:bg-red-600 transition-all">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data karyawan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination & Tombol Kembali -->
                <div class="mt-6 flex justify-between items-center">
                    <div>
                        {{ $karyawans->links() }}
                    </div>
                    <a href="{{ url()->previous() }}" class="bg-gray-500 text-white px-3 py-2 rounded-lg shadow hover:bg-gray-600 transition-all">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Live Search -->
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var input = this.value.toLowerCase();
            var rows = document.querySelectorAll('#karyawanTable tr');

            rows.forEach(function(row) {
                var nikCell = row.querySelector('.karyawan-nik');
                var nameCell = row.querySelector('.karyawan-name');
                
                if (nikCell && nameCell) {
                    var nikText = nikCell.textContent.toLowerCase();
                    var nameText = nameCell.textContent.toLowerCase();
                    
                    if (nikText.includes(input) || nameText.includes(input)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    </script>
</x-app-layout>
