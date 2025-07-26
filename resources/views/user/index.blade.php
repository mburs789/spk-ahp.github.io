<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Data User') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-800 shadow-lg rounded-2xl p-6 border border-gray-200">
                
                <!-- Notifikasi -->
                @if (session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 border border-green-300 shadow-md">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Judul Daftar User -->
                <h2 class="text-xl font-semibold mb-4">Daftar User</h2>

                <!-- Filter, Pencarian, dan Tombol Tambah -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-2">
                    <form method="GET" class="flex flex-wrap items-center gap-2">
                        <input type="text" id="searchInput" placeholder="Cari Nama User..." 
                            class="border rounded-lg px-3 py-1 focus:ring-2 focus:ring-blue-300">
                        
                        <select name="role" class="border rounded-lg px-3 py-1 focus:ring-2 focus:ring-blue-300 w-40">
                            <option value="">-- Pilih Peran --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                        
                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-lg shadow hover:bg-blue-700 transition-all">
                            Cari
                        </button>
                    </form>

                    <!-- Tombol Tambah User -->
                    <a href="{{ route('user.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded-lg shadow hover:bg-blue-700 transition-all">
                        Tambah User
                    </a>
                </div>

                <!-- Tabel User -->
                <div class="overflow-x-auto rounded-lg shadow-md">
                    <table class="w-full border-collapse bg-white shadow-md rounded-lg text-center">
                        <thead>
                            <tr class="bg-gray-200 text-gray-800">
                                <th class="px-4 py-3 border">No</th>
                                <th class="px-4 py-3 border">Nama User</th>
                                <th class="px-4 py-3 border">Email</th>
                                <th class="px-4 py-3 border">Peran</th>
                                <th class="px-4 py-3 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="userTable">
                            @forelse($users as $index => $user)
                            <tr class="hover:bg-gray-100 transition-all">
                                <td class="px-4 py-3 border">{{ $users->firstItem() + $index }}</td>
                                <td class="px-4 py-3 border user-name">{{ $user->name }}</td>
                                <td class="px-4 py-3 border">{{ $user->email }}</td>
                                <td class="px-4 py-3 border">{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                                <td class="px-4 py-3 border flex justify-center space-x-2">
                                    <a href="{{ route('user.edit', $user->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow hover:bg-yellow-600 transition-all">
                                        Edit
                                    </a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg shadow hover:bg-red-600 transition-all" onclick="return confirm('Yakin ingin menghapus?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data pengguna.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination & Tombol Kembali -->
                <div class="mt-6 flex justify-between items-center">
                    <div>
                        {{ $users->links() }}
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
            var rows = document.querySelectorAll('#userTable tr');

            rows.forEach(function(row) {
                var nameCell = row.querySelector('.user-name');
                if (nameCell) {
                    var nameText = nameCell.textContent.toLowerCase();
                    row.style.display = nameText.includes(input) ? '' : 'none';
                }
            });
        });
    </script>
</x-app-layout>
