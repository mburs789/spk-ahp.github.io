<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Perangkingan Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-1">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white text-gray-800 shadow-lg rounded-2xl p-6 border border-gray-200">
            
            <!-- Notifikasi jika ada session success -->
            @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-lg border border-green-300 shadow-md">
                {{ session('success') }}
            </div>
            @endif

            <!-- Hasil Perangkingan -->
            <h2 class="text-xl font-bold text-gray-800 mb-4">Hasil Perangkingan</h2>

            <div class="flex justify-end items-center mb-6 pr-4">
                <a href="{{ route('perangkingan.export-pdf') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md 
                          hover:bg-blue-700 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" x2="8" y1="13" y2="13"/>
                        <line x1="16" x2="8" y1="17" y2="17"/>
                        <line x1="10" x2="8" y1="9" y2="9"/>
                    </svg>
                    Export to PDF
                </a>
            </div>                        

            <div class="overflow-x-auto rounded-lg shadow-md">
                <table class="w-full border-collapse bg-white shadow-md rounded-lg text-center">
                    <thead class="bg-gray-200 text-gray-800">
                        <tr>
                            <th class="px-4 py-3 border">Nama Karyawan</th>
                            <th class="px-4 py-3 border">Total Nilai</th>
                            <th class="px-4 py-3 border">Ranking</th>
                            <th class="px-4 py-3 border">Status</th>
                            <th class="px-4 py-3 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paginatedResults as $index => $hasil)
                            <tr class="hover:bg-gray-100 transition-all">
                                <td class="px-4 py-3 border text-lg">{{ $hasil['nama_karyawan'] }}</td>
                                <td class="px-4 py-3 border text-lg font-semibold">{{ number_format($hasil['total_nilai'], 6) }}</td>
                                <td class="px-4 py-3 border text-lg font-bold text-blue-600">{{ $loop->iteration + ($paginatedResults->currentPage() - 1) * 10 }}</td>
                                
                                <td class="px-4 py-3 border text-lg">
                                    @if($hasil['status'] == 'pending')
                                        <span class="text-yellow-600">Pending</span>
                                    @elseif($hasil['status'] == 'accepted')
                                        <span class="text-green-600">Accepted</span>
                                    @elseif($hasil['status'] == 'rejected')
                                        <span class="text-red-600">Rejected</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 border text-lg">
                                    @if($hasil['status'] == 'pending')
                                        <!-- Tombol untuk menerima -->
                                        <form action="{{ route('perangkingan.updateStatus', $hasil['ranking']) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="status" value="accepted" class="px-3 py-1 text-white bg-blue-600 hover:bg-blue-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">Accept</button>
                                        </form>
                                        
                                        <!-- Tombol untuk menolak -->
                                        <form action="{{ route('perangkingan.updateStatus', $hasil['ranking']) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="status" value="rejected" class="px-3 py-1 text-white bg-red-600 hover:bg-red-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400">Reject</button>
                                        </form>
                                    @else
                                        <!-- Tidak ada tombol jika status sudah diterima atau ditolak -->
                                        <span class="text-gray-500">Status sudah dipilih</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginasi -->
            <div class="mt-4">
                {{ $paginatedResults->links() }}
            </div>

            <!-- Grafik Garis -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Grafik Perangkingan</h2>
                <canvas id="rankingChart"></canvas>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
            document.addEventListener("DOMContentLoaded", function () {
                var labels = @json($grafikDataCollection->pluck('nama_karyawan'));
                var rankings = @json($grafikDataCollection->pluck('ranking'));

                if (!document.getElementById('rankingChart')) {
                    console.error("Canvas #rankingChart tidak ditemukan!");
                    return;
                }

                var ctx = document.getElementById('rankingChart').getContext('2d');
                var rankingChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Ranking',
                            data: rankings,
                            borderColor: 'rgb(54, 162, 235)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: true,
                            tension: 0.3,
                            pointRadius: 5,
                            pointHoverRadius: 7
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
                                reverse: false, // Ubah ke false, karena kita ingin ranking 1 di atas
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
</x-app-layout>
