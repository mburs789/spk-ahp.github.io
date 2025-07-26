<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\PerbandinganKriteria;
use App\Models\Subkriteria;
use App\Models\PerbandinganSubkriteria;

class PerbandinganSubkriteriaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kriteria
        $kriterias = Kriteria::all();
    
        // Cek apakah ada input kriteria_id baru, jika ada simpan ke session
        if ($request->has('kriteria_id')) {
            session(['kriteria_id' => $request->kriteria_id]);
        }
    
        // Ambil kriteria_id dari session, jika tidak ada gunakan kriteria pertama sebagai default
        //$selectedKriteria = session('kriteria_id', $kriterias->isNotEmpty() ? $kriterias->first()->id : null);
        $selectedKriteria = session('kriteria_id', null);
    
        // Jika tidak ada kriteria di database, hindari error
        if (!$selectedKriteria) {
            return redirect()->back()->with('error', 'Belum ada kriteria yang tersedia.');
        }
    
        // Ambil subkriteria berdasarkan kriteria yang dipilih
        $subkriterias = Subkriteria::where('kriteria_id', $selectedKriteria)->get();
        $n = $subkriterias->count();
    
        // Ambil data perbandingan berdasarkan subkriteria yang ada
        $perbandingan = PerbandinganSubkriteria::where('kriteria_id', $selectedKriteria)->get();
    
        // Inisialisasi matriks perbandingan
        $matrix = [];
        foreach ($subkriterias as $sk1) {
            foreach ($subkriterias as $sk2) {
                $nilai = PerbandinganSubkriteria::where('subkriteria_1_id', $sk1->id)
                                                ->where('subkriteria_2_id', $sk2->id)
                                                ->value('nilai') ?? ($sk1->id == $sk2->id ? 1 : 0);
                $matrix[$sk1->id][$sk2->id] = $nilai;
            }
        }    
    
        // Hitung jumlah kolom
        $sumColumns = array_fill_keys($subkriterias->pluck('id')->toArray(), 0);
        foreach ($matrix as $row) {
            foreach ($row as $colIndex => $value) {
                if (isset($sumColumns[$colIndex])){
                    $sumColumns[$colIndex] += $value;
                }
            }
        }
    
        // Normalisasi & eigen vector
        $normalizedMatrix = [];
        $eigenVector = array_fill_keys($subkriterias->pluck('id')->toArray(), 0);
        foreach ($matrix as $rowIndex => $row) {
            foreach ($row as $colIndex => $value) {
                if (isset($sumColumns[$colIndex]) && $sumColumns[$colIndex] != 0){
                    $normalizedMatrix[$rowIndex][$colIndex] = $value / $sumColumns[$colIndex];
                    $eigenVector[$rowIndex] += $normalizedMatrix[$rowIndex][$colIndex];
                } else {
                    $normalizedMatrix[$rowIndex][$colIndex] = 0;
                }
            }
            $eigenVector[$rowIndex] /= count($subkriterias);
        }
    
        // Simpan eigenVector ke dalam database
        foreach ($eigenVector as $subkriteria_id => $nilai) {
            $nilai = round($nilai, 6);
            Subkriteria::where('id', $subkriteria_id)->update(['eigen_vector' => $nilai]);
        }
    
        // Konsistensi
        $lambdaMax = 0;
        foreach ($matrix as $rowIndex => $row) {
            $sumRow = 0;
            foreach ($row as $colIndex => $value) {
                $sumRow += $value * $eigenVector[$colIndex];
            }
            $lambdaMax += $sumRow / $eigenVector[$rowIndex];
        }
        $lambdaMax /= $n;
        $lambdaMax = round($lambdaMax, 6);
        $CI = ($lambdaMax - $n) / ($n - 1);
        $CI = round($CI, 6);
        $RI_values = [0, 0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49];
        $RI = isset($RI_values[$n]) ? $RI_values[$n] : 1.5;
    
        $CR = $CI / $RI;
        $CR = round($CR, 6);
    
        return view('perbandingansubkriteria.index', compact('kriterias', 'selectedKriteria', 'subkriterias', 'perbandingan', 'matrix', 'sumColumns', 'normalizedMatrix', 'eigenVector', 'CI', 'CR', 'lambdaMax'));
    }
    
    public function store(Request $request)
    {
        \Log::info('Request Diterima:', $request->all());
        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'subkriteria_1' => 'required|different:subkriteria_2',
            'subkriteria_2' => 'required',
            'nilai' => 'required|numeric|min:0.1|max:9',
        ]);
        \Log::info('Validasi berhasil!');
    
        // Dapatkan kriteria_id dari subkriteria yang dipilih
        $kriteria_id = $request->input('kriteria_id');
    
        $perbandingan1 = PerbandinganSubkriteria::updateOrCreate(
            [
                'kriteria_id' => $kriteria_id,
                'subkriteria_1_id' => $request->subkriteria_1,
                'subkriteria_2_id' => $request->subkriteria_2,
            ],
            ['nilai' => $request->nilai]
        );
        \Log::info('Perbandingan Normal:', $perbandingan1->toArray());
        
        $perbandingan2 = PerbandinganSubkriteria::updateOrCreate(
            [
                'kriteria_id' => $kriteria_id,
                'subkriteria_1_id' => $request->subkriteria_2,
                'subkriteria_2_id' => $request->subkriteria_1,
            ],
            ['nilai' => 1 / $request->nilai]
        );
        \Log::info('Perbandingan Invers:', $perbandingan2->toArray());
        
        return redirect()->route('perbandingansubkriteria.index')->with('success', 'Perbandingan berhasil disimpan.');
    }
    
}