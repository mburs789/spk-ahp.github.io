<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Edit Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200">
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 border border-red-300 shadow-md">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('kriteria.update', $kriteria->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Dropdown Kode Kriteria -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Kode Kriteria</label>
                        <select id="kode_kriteria" name="kode_kriteria" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-300" required>
                            <option value="">Pilih Kode Kriteria</option>
                            @foreach ($daftarKriteria as $kode => $nama)
                                <option value="{{ $kode }}" {{ $kode == $kriteria->kode_kriteria ? 'selected' : '' }}>{{ $kode }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input Nama Kriteria (Bisa Diedit) -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nama Kriteria</label>
                        <input type="text" id="nama_kriteria" name="nama_kriteria" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-300" value="{{ $kriteria->nama_kriteria }}">
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition-all">Simpan Perubahan</button>
                        <a href="{{ route('kriteria.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600 transition-all">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Ambil data dari Blade ke JavaScript
        const daftarKriteria = @json($daftarKriteria);

        document.getElementById("kode_kriteria").addEventListener("change", function() {
            let selectedKode = this.value;
            if (selectedKode) {
                document.getElementById("nama_kriteria").value = daftarKriteria[selectedKode]; // Isi otomatis
            }
        });
    </script>

</x-app-layout>
