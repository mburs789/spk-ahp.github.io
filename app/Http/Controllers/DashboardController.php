<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Subkriteria;
use App\Models\Penilaian;
use App\Models\User;
use App\Models\Perangkingan;


class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::count();
        $totalKaryawan = Karyawan::count();
        $totalKriteria = Kriteria::count();
        $totalSubkriteria = Subkriteria::count();
        $totalPenilaian = Penilaian::count();
    // Ambil semua karyawan
    $karyawans = Karyawan::all();

    // Hitung total_nilai untuk setiap karyawan
    $hasilPenilaian = [];

    foreach ($karyawans as $karyawan) {
        $penilaians = Penilaian::where('karyawan_id', $karyawan->id)
                                ->with(['subkriteria.kriteria'])
                                ->get();

        $totalNilai = 0;

        foreach ($penilaians as $penilaian) {
            if ($penilaian->subkriteria && $penilaian->subkriteria->kriteria) {
                $eigenKriteria = $penilaian->subkriteria->kriteria->eigen_vector ?? 0;
                $eigenSubkriteria = $penilaian->subkriteria->eigen_vector ?? 0;

                $totalNilai += $eigenKriteria * $eigenSubkriteria;
            }
        }

        $perangkingan = Perangkingan::where('karyawan_id', $karyawan->id)->first();

        $hasilPenilaian[] = [
            'karyawan_id'    => $karyawan->id,
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

    // Ambil hanya 5 karyawan terbaik
    $topKaryawan = array_slice($hasilPenilaian, 0, 5);

    $grafikNamaKaryawan = [];
    $grafikRanking = [];

    // Ambil data dari top 5 karyawan untuk grafik
    foreach ($topKaryawan as $karyawan) {
        $grafikNamaKaryawan[] = $karyawan['nama_karyawan']; // Nama karyawan
        $grafikRanking[] = $karyawan['ranking']; // Ranking karyawan
    }

    // Mengacak urutan karyawan untuk membuat grafik lebih menarik
$shuffledData = array_map(null, $grafikNamaKaryawan, $grafikRanking);
shuffle($shuffledData);

$grafikNamaKaryawan = array_column($shuffledData, 0);
$grafikRanking = array_column($shuffledData, 1);

        return view('dashboard', compact(
            'totalUser',
            'totalKaryawan', 
            'totalKriteria', 
            'totalSubkriteria', 
            'totalPenilaian',
            'topKaryawan',
            'grafikNamaKaryawan',
            'grafikRanking'
        ));
    }
}
