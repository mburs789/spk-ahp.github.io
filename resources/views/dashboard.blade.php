<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200">
                
                <!-- Notifikasi -->
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 border border-green-300 shadow-md">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Ringkasan Data -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Ringkasan Data</h2>
                </div>

<!-- Grid Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        @role('admin')
        <!-- Total Pengguna -->
        <a href="{{ route('user.index') }}" class="flex flex-col items-center bg-white shadow-md rounded-xl p-5 border border-gray-200 text-center transition transform hover:scale-105 hover:shadow-lg">
            <div class="w-14 h-14 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-user-tie text-2xl"></i>
            </div>
            <h3 class="mt-4 text-lg font-semibold text-gray-800">Total Pengguna</h3>
            <p class="text-3xl font-extrabold text-blue-600 mt-2">{{ $totalUser }}</p>
        </a>
    @endrole
    
    @role('admin|supervisor')
        <!-- Total Karyawan -->
        <a href="{{ route('karyawan.index') }}" class="flex flex-col items-center bg-white shadow-md rounded-xl p-5 border border-gray-200 text-center transition transform hover:scale-105 hover:shadow-lg">
            <div class="w-14 h-14 flex items-center justify-center rounded-full bg-green-100 text-green-600">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <h3 class="mt-4 text-lg font-semibold text-gray-800">Total Karyawan</h3>
            <p class="text-3xl font-extrabold text-green-600 mt-2">{{ $totalKaryawan }}</p>
        </a>

        <!-- Total Kriteria -->
        <a href="{{ route('kriteria.index') }}" class="flex flex-col items-center bg-white shadow-md rounded-xl p-5 border border-gray-200 text-center transition transform hover:scale-105 hover:shadow-lg">
            <div class="w-14 h-14 flex items-center justify-center rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-list text-2xl"></i>
            </div>
            <h3 class="mt-4 text-lg font-semibold text-gray-800">Total Kriteria</h3>
            <p class="text-3xl font-extrabold text-yellow-600 mt-2">{{ $totalKriteria }}</p>
        </a>

        <!-- Total Penilaian -->
        <a href="{{ route('penilaian.index') }}" class="flex flex-col items-center bg-white shadow-md rounded-xl p-5 border border-gray-200 text-center transition transform hover:scale-105 hover:shadow-lg">
            <div class="w-14 h-14 flex items-center justify-center rounded-full bg-red-100 text-red-600">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <h3 class="mt-4 text-lg font-semibold text-gray-800">Total Penilaian</h3>
            <p class="text-3xl font-extrabold text-red-600 mt-2">{{ $totalPenilaian }}</p>
        </a>
    @endrole
</div>

                <!-- Daftar Ranking Karyawan Terbaik -->
                <div class="mt-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Top 5 Karyawan Terbaik</h2>
                    <div class="overflow-x-auto rounded-lg shadow-md">
                        <table class="w-full border-collapse bg-white shadow-md rounded-lg text-center">
                            <thead class="bg-gray-200 text-gray-800">
                                <tr>
                                    <th class="px-4 py-3 border">Ranking</th>
                                    <th class="px-4 py-3 border">Nama Karyawan</th>
                                    <th class="px-4 py-3 border">Total Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topKaryawan as $index => $karyawan)
                                    <tr class="hover:bg-gray-100 transition-all">
                                        <td class="px-4 py-3 border font-bold text-blue-600">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 border">{{ $karyawan['nama_karyawan'] }}</td>
                                        <td class="px-4 py-3 border font-semibold">{{ number_format($karyawan['total_nilai'], 6) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

<!-- Grafik Perangkingan -->
<div class="mt-8">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Grafik Perangkingan Karyawan</h2>
    <canvas id="rankingChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    var ctx = document.getElementById('rankingChart').getContext('2d');

    var rankingChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($grafikNamaKaryawan), // Nama-nama karyawan diacak agar lebih menarik
            datasets: [{
                label: 'Ranking',
                data: @json($grafikRanking), // Ranking dari perangkingan tetap sesuai
                borderColor: 'rgb(54, 162, 235)', // Warna biru
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Warna transparan biru muda
                fill: true,
                tension: 0.4, // Membuat garis lebih bergelombang
                pointRadius: 6, // Ukuran titik di garis
                pointHoverRadius: 8, // Efek hover lebih besar
                pointBackgroundColor: 'rgb(54, 162, 235)', // Warna titik biru
                pointBorderColor: 'white', // Pinggiran putih agar lebih elegan
                borderWidth: 3 // Lebar garis lebih tebal
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    reverse: true, // Ranking terbaik (1) tetap di atas
                    ticks: {
                        stepSize: 1,
                        callback: function(value) { return 'Ranking ' + value; }
                    }
                }
            }
        }
    });
});
</script>

            </div>
        </div>
    </div>
</x-app-layout>
