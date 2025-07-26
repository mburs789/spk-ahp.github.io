<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\PerbandinganKriteria;

class PerbandinganKriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::all();
        $n = $kriterias->count();
        $perbandingan = PerbandinganKriteria::all();

        // Inisialisasi matriks
        $matrix = [];
        foreach ($kriterias as $k1) {
            foreach ($kriterias as $k2) {
                $nilai = PerbandinganKriteria::where('kriteria_1_id', $k1->id)
                                             ->where('kriteria_2_id', $k2->id)
                                             ->value('nilai') ?? ($k1->id == $k2->id ? 1 : 0);
                $matrix[$k1->id][$k2->id] = $nilai;
            }
        }

        // Hitung jumlah kolom
        $sumColumns = array_fill_keys($kriterias->pluck('id')->toArray(),0);
        foreach ($matrix as $row) {
            foreach ($row as $colIndex => $value) {
                if (isset($sumColumns[$colIndex])){
                    $sumColumns[$colIndex] += $value;
                }
                
            }
        }

        // Normalisasi & eigen vector
        $normalizedMatrix = [];
        $eigenVector = array_fill_keys($kriterias->pluck('id')->toArray(), 0);
        foreach ($matrix as $rowIndex => $row) {
            foreach ($row as $colIndex => $value) {
                if (isset($sumColumns[$colIndex]) && $sumColumns[$colIndex] != 0){
                    $normalizedMatrix[$rowIndex][$colIndex] = $value / $sumColumns[$colIndex];
                    $eigenVector[$rowIndex] += $normalizedMatrix[$rowIndex][$colIndex];
                } else {
                    $normalizedMatrix[$rowIndex][$colIndex] = 0;
                }
            }
            $eigenVector[$rowIndex] /= count ($kriterias);
            $eigenVector[$rowIndex] = round($eigenVector[$rowIndex], 6);
        }

        // Simpan eigenVector ke dalam database
        foreach ($eigenVector as $kriteria_id => $nilai) {
            $nilai = round($nilai, 6);
            Kriteria::where('id', $kriteria_id)->update(['eigen_vector' => $nilai]);
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

        return view('perbandingankriteria.index', compact('kriterias', 'perbandingan', 'matrix', 'sumColumns', 'normalizedMatrix', 'eigenVector', 'CI', 'CR', 'lambdaMax'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kriteria_1' => 'required|different:kriteria_2',
            'kriteria_2' => 'required',
            'nilai' => 'required|numeric|min:0.1|max:9',
        ]);

        PerbandinganKriteria::updateOrCreate(
            ['kriteria_1_id' => $request->kriteria_1, 'kriteria_2_id' => $request->kriteria_2],
            ['nilai' => $request->nilai]
        );

        PerbandinganKriteria::updateOrCreate(
            ['kriteria_1_id' => $request->kriteria_2, 'kriteria_2_id' => $request->kriteria_1],
            ['nilai' => 1 / $request->nilai]
        );

        return redirect()->route('perbandingankriteria.index')->with('success', 'Perbandingan berhasil disimpan.');
    }
}