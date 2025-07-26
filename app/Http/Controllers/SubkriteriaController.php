<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subkriteria;
use App\Models\Kriteria;

class SubkriteriaController extends Controller
{
    public function getByKriteria(Request $request)
    {
        $subkriterias = Subkriteria::where('kriteria_id', $request->kriteria_id)->get();
        return response()->json($subkriterias);
    }

    public function index(Request $request)
    {
        //$kriteria_id = $request->get('kriteria_id', Kriteria::first()->id ?? null); // Default ke kriteria pertama jika ada
        //$subkriterias = Subkriteria::where('kriteria_id', $kriteria_id)->with('kriteria')->get();
        $kriteria_id = $request->get('kriteria_id'); // Jangan default ke kriteria pertama

        $subkriterias = collect(); // Default kosong
        if ($kriteria_id) {
        $subkriterias = Subkriteria::where('kriteria_id', $kriteria_id)->with('kriteria')->get();
        }
        $kriterias = Kriteria::all(); // Ambil semua kriteria untuk dropdown filter

        return view('subkriteria.index', compact('subkriterias', 'kriterias', 'kriteria_id'));
    }

    public function create()
    {
        $kriterias = Kriteria::all();
        return view('subkriteria.create', compact('kriterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kriteria_id' => 'required',
            'kode_subkriteria' => 'required',
            'nama_subkriteria' => 'required',
            'nilai_min' => 'required|numeric|min:0|max:10',
            'nilai_max' => 'required|numeric|min:0|max:10',
        ]);

        Subkriteria::create($request->all());
        return redirect()->route('subkriteria.index')->with('success', 'Subkriteria berhasil ditambahkan.');
    }

    public function edit($id) // ✅ Gunakan $id, jangan model binding
    {
        $subkriteria = Subkriteria::findOrFail($id);
        $kriterias = Kriteria::all();
        return view('subkriteria.edit', compact('subkriteria', 'kriterias'));
    }

    public function update(Request $request, $id) // ✅ Gunakan $id, jangan model binding
    {
        $request->validate([
            'kriteria_id' => 'required',
            'kode_subkriteria' => 'required',
            'nama_subkriteria' => 'required',
            'nilai_min' => 'required|numeric|min:0|max:10',
            'nilai_max' => 'required|numeric|min:0|max:10',
        ]);

        $subkriteria = Subkriteria::findOrFail($id);
        $subkriteria->update($request->all());

        return redirect()->route('subkriteria.index')->with('success', 'Subkriteria berhasil diperbarui.');
    }

    public function destroy($id) // ✅ Gunakan $id, jangan model binding
    {
        $subkriteria = Subkriteria::findOrFail($id);
        $subkriteria->delete();

        return redirect()->route('subkriteria.index')->with('success', 'Subkriteria berhasil dihapus.');
    }
}
