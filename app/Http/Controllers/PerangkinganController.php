<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perangkingan;
use App\Models\Karyawan;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Notifications\PerangkinganStatusChanged;

class PerangkinganController extends Controller
{
    public function index()
    {
        // Ambil semua karyawan
        $karyawans = Karyawan::all();
    
        // Array untuk menyimpan hasil perangkingan
        $hasilPenilaian = [];
    
        foreach ($karyawans as $karyawan) {
            // Ambil semua penilaian berdasarkan karyawan
            $penilaians = Penilaian::where('karyawan_id', $karyawan->id)
                                    ->with(['subkriteria.kriteria'])
                                    ->get();
    
            $totalNilai = 0;
    
            foreach ($penilaians as $penilaian) {
                if ($penilaian->subkriteria && $penilaian->subkriteria->kriteria) {
                    $eigenKriteria = $penilaian->subkriteria->kriteria->eigen_vector ?? 0;
                    $eigenSubkriteria = $penilaian->subkriteria->eigen_vector ?? 0;
    
                    // Hitung total nilai dengan menjumlahkan hasil perkalian eigen vector
                    $totalNilai += $eigenKriteria * $eigenSubkriteria;
                }
            }
    
            // Ambil data perangkingan berdasarkan karyawan_id
            $perangkingan = Perangkingan::where('karyawan_id', $karyawan->id)->first();

            // Tentukan status, jika perangkingan ditemukan, gunakan status yang ada, jika tidak, set status 'pending'
            $status = $perangkingan ? $perangkingan->status : 'pending';

            // Simpan hasil ke array
            $hasilPenilaian[] = [
                'karyawan_id' => $karyawan->id,
                'nama_karyawan' => $karyawan->nama_karyawan,
                'total_nilai' => $totalNilai,
                'status' => $status,  // Status berdasarkan status yang ditemukan atau 'pending'
            ];            
        }
    
        // Urutkan berdasarkan total nilai tertinggi
        usort($hasilPenilaian, function ($a, $b) {
            return $b['total_nilai'] <=> $a['total_nilai'];
        });

        // Tambahkan kolom ranking berdasarkan urutan setelah sorting
        foreach ($hasilPenilaian as $index => &$hasil) {
            $hasil['ranking'] = $index + 1; // Ranking mulai dari 1
        }
        unset($hasil); // Hindari referensi yang tidak diinginkan
    
        // Simpan ranking ke database
        foreach ($hasilPenilaian as $hasil) {
            // Pastikan hanya yang status 'pending' yang diperbarui
            $perangkingan = Perangkingan::updateOrCreate(
                ['karyawan_id' => $hasil['karyawan_id']], // Temukan berdasarkan karyawan_id
                [
                    'ranking' => $hasil['ranking'],
                    'status' => $hasil['status'] === 'pending' ? 'pending' : $hasil['status'],  // Pastikan status tetap
                ]
            );
        }
    
        // Buat array asosiatif untuk menyimpan ranking berdasarkan ID karyawan
        $rankingById = [];
        foreach ($hasilPenilaian as $hasil) {
            $rankingById[$hasil['karyawan_id']] = $hasil['ranking'];
        }
    
        // Ambil semua karyawan dalam urutan ID asli
        $orderedKaryawans = Karyawan::orderBy('id')->get();
    
        // Buat array final untuk grafik yang diurutkan berdasarkan ID karyawan
        $grafikData = [];
        foreach ($orderedKaryawans as $karyawan) {
            $grafikData[] = [
                'nama_karyawan' => $karyawan->nama_karyawan,
                'ranking' => $rankingById[$karyawan->id] ?? null, // Ranking sesuai perangkingan
            ];
        }
    
        // Konversi hasil ke koleksi
        $grafikDataCollection = collect($grafikData);
        $hasilPenilaianCollection = collect($hasilPenilaian);

        // Pagination
        $perPage = 10;
        $currentPage = Paginator::resolveCurrentPage();
        $currentItems = $hasilPenilaianCollection->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedResults = new LengthAwarePaginator(
            $currentItems,
            $hasilPenilaianCollection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );

        return view('perangkingan.index', compact('paginatedResults', 'grafikDataCollection'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);
    
        // Temukan perankingan berdasarkan ID
        $perangkingan = Perangkingan::findOrFail($id);
    
        // Cek jika status sudah diterima atau ditolak, jangan ubah lagi
        if ($perangkingan->status !== 'pending') {
            return redirect()->route('perangkingan.index')
                             ->with('info', 'Status sudah diubah sebelumnya.');
        }
    
        // Update status
        $perangkingan->status = $request->status;
        $perangkingan->save();
    
        // Kirim notifikasi ke supervisor setelah status diperbarui
        $supervisors = User::role('supervisor')->get();
        foreach ($supervisors as $supervisor) {
            $supervisor->notify(new PerangkinganStatusChanged($perangkingan));
        }
    
        // Flash message
        return redirect()->route('perangkingan.index')->with('success', 'Status perankingan berhasil diperbarui');        
    }

    public function exportPdf()
    {
        // Ambil semua karyawan
        $karyawans = Karyawan::all();
        
        // Array untuk menyimpan hasil perangkingan
        $hasilPenilaian = [];
    
        foreach ($karyawans as $karyawan) {
            // Ambil semua penilaian berdasarkan karyawan
            $penilaians = Penilaian::where('karyawan_id', $karyawan->id)
                                    ->with(['subkriteria.kriteria'])
                                    ->get();
    
            $totalNilai = 0;
    
            foreach ($penilaians as $penilaian) {
                if ($penilaian->subkriteria && $penilaian->subkriteria->kriteria) {
                    $eigenKriteria = $penilaian->subkriteria->kriteria->eigen_vector ?? 0;
                    $eigenSubkriteria = $penilaian->subkriteria->eigen_vector ?? 0;
    
                    // Hitung total nilai
                    $totalNilai += $eigenKriteria * $eigenSubkriteria;
                }
            }
    
            // Ambil data perangkingan berdasarkan karyawan_id
            $perangkingan = Perangkingan::where('karyawan_id', $karyawan->id)->first();
    
            $hasilPenilaian[] = [
                'karyawan_id'    => $karyawan->id,
                'nik'            => $karyawan->nik,
                'nama_karyawan'  => $karyawan->nama_karyawan,
                'total_nilai'    => $totalNilai,
                'ranking'        => $perangkingan->ranking ?? null,
                'status'         => $perangkingan->status ?? 'pending',
            ];
        }
    
        // Urutkan berdasarkan total nilai tertinggi
        usort($hasilPenilaian, function ($a, $b) {
            return $b['total_nilai'] <=> $a['total_nilai'];
        });
    
        // Load view dengan data perangkingan
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('perangkingan.export-pdf', ['data' => $hasilPenilaian]);
    
        // Set ukuran kertas dan orientasi
        $pdf->setPaper('A4', 'portrait');
    
        // Download PDF
        return $pdf->download('laporan_perangkingan.pdf');
    }
        
}
