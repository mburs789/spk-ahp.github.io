<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Subkriteria;
use App\Models\Penilaian;

class PenilaianController extends Controller
{

    public function index(Request $request)
    {
        // Ambil semua karyawan yang memiliki penilaian
        $karyawans = Karyawan::whereHas('penilaians')->get();
    
        // Ambil karyawan yang dipilih dari dropdown, default ke karyawan pertama
        $selectedKaryawan = $request->karyawan_id;
    
        // Ambil semua penilaian berdasarkan karyawan yang dipilih
        $penilaians = collect();
        if ($selectedKaryawan) {
            $penilaians = Penilaian::where('karyawan_id', $selectedKaryawan)
                ->with(['subkriteria.kriteria'])
                ->get();
        }

        return view('penilaian.index', compact('karyawans', 'selectedKaryawan', 'penilaians'));
    }
    
    
    public function create()
    {
        $karyawans = Karyawan::all();
        $kriterias = Kriteria::all();
    
        return view('penilaian.create', compact('karyawans', 'kriterias'));
    }    
    
    public function store(Request $request)
    {
    $request->validate([
        'karyawan_id' => 'required',
        'nilai.*' => 'required|numeric|min:0|max:10',
    ]);

    foreach ($request->nilai as $kriteria_id => $nilai) {
        // Cari subkriteria yang sesuai dengan nilai yang diinput
        $subkriteria = Subkriteria::where('kriteria_id', $kriteria_id)
            ->where('nilai_min', '<=', $nilai)
            ->where('nilai_max', '>=', $nilai)
            ->first();

        Penilaian::updateOrCreate(
            [
                'karyawan_id' => $request->karyawan_id,
                'kriteria_id' => $kriteria_id, // Tambahkan kriteria_id
            ],
            [
                'subkriteria_id' => $subkriteria ? $subkriteria->id : null,
                'nilai' => $nilai
            ]
        );
    }

    return redirect()->route('penilaian.index', ['karyawan_id' => $request->karyawan_id])->with('success', 'Penilaian berhasil disimpan.');
}

    public function edit(Penilaian $penilaian)
    {
        $karyawans = Karyawan::all();
        $kriterias = Kriteria::all();
        return view('penilaian.edit', compact('penilaian', 'karyawans', 'kriterias'));
    }

    public function update(Request $request, Penilaian $penilaian)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:10',
        ]);

        $subkriteria = Subkriteria::where('kriteria_id', $penilaian->kriteria_id)
            ->where('nilai_min', '<=', $request->nilai)
            ->where('nilai_max', '>=', $request->nilai)
            ->first();

        if ($subkriteria) {
            $penilaian->update([
                'nilai' => $request->nilai,
                'subkriteria_id' => $subkriteria->id,
            ]);
        }

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Penilaian::findOrFail($id)->delete();
        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil dihapus.');
    }
}
