<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::all();
        return view('kriteria.index', compact('kriterias'));
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kriteria' => 'required|unique:kriterias,kode_kriteria',
            'nama_kriteria' => 'required'
        ]);

        Kriteria::create([
            'kode_kriteria' => $request->kode_kriteria,
            'nama_kriteria' => $request->nama_kriteria
        ]);
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan');
    }

    // public function edit(Request $request, $id)
    // {
    //     $kriteria = Kriteria::findOrFail($id);
    //     return view('kriteria.edit', compact('kriteria'));
    // }
    
    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        // Ambil daftar kriteria dari database (sesuaikan dengan struktur tabel Anda)
        $daftarKriteria = Kriteria::pluck('nama_kriteria', 'kode_kriteria');
        return view('kriteria.edit', compact('kriteria', 'daftarKriteria'));
    }

    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->update($request->all());
    
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diperbarui');
    }
    

    public function destroy(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus');
    }
}
