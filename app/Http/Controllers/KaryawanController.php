<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $karyawans = Karyawan::where('nama_karyawan', 'LIKE', "%$search%")
                             ->orWhere('nik', 'LIKE', "%$search%")
                             ->paginate(10);

        return view('karyawan.index', compact('karyawans', 'search'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:karyawans,nik',
            'nama_karyawan' => 'required',
            'jabatan' => 'required',
        ]);

        Karyawan::create($request->all());

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nik' => 'required|unique:karyawans,nik,' . $karyawan->id,
            'nama_karyawan' => 'required',
            'jabatan' => 'required',
        ]);

        $karyawan->update($request->all());

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Data Karyawan berhasil dihapus.');
    }
}