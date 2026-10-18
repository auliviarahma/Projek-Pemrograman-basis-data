<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Ditambahkan untuk query Database View

class SatuanController extends Controller
{
    // READ 1: Menampilkan daftar data satuan langsung dari Database View (view_satuan)
    public function index()
    {
        $satuan = DB::table('view_satuan')->get();
        return view('satuan.index', compact('satuan'));
    }

    // Menampilkan halaman form tambah satuan
    public function create()
    {
        return view('satuan.create');
    }

    // CREATE: Menyimpan data baru tetap ke tabel fisik satuan via Model
    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|max:45',
            'status'      => 'required|numeric',
        ]);

        Satuan::create($request->all());

        return redirect()->route('satuan.index')->with('success', 'Data satuan berhasil ditambahkan');
    }

    public function show(string $id)
    {
        // Kosongkan jika tidak memerlukan halaman detail terpisah
    }

    // READ 2: Mengambil detail data satuan untuk form edit langsung dari Database View (view_satuan)
    public function edit(string $id)
    {
        $satuan = DB::table('view_satuan')->where('idsatuan', $id)->first();

        if (!$satuan) {
            abort(404, 'Data satuan tidak ditemukan');
        }

        return view('satuan.edit', compact('satuan'));
    }

    // UPDATE: Memperbarui data pada tabel fisik satuan via Model
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_satuan' => 'required|max:45',
            'status'      => 'required|numeric',
        ]);

        $satuan = Satuan::findOrFail($id);
        $satuan->update($request->all());

        return redirect()->route('satuan.index')->with('success', 'Data satuan berhasil diperbarui');
    }

    // DELETE: Menghapus data dari tabel fisik satuan via Model
    public function destroy(string $id)
    {
        $satuan = Satuan::findOrFail($id);
        $satuan->delete();

        return redirect()->route('satuan.index')->with('success', 'Data satuan berhasil dihapus');
    }
}