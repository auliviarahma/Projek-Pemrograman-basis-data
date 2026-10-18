<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    // READ 1: Menampilkan daftar tabel dari view_barang
    public function index()
    {
        $barang = DB::table('view_barang')->get();
        return view('barang.index', compact('barang'));
    }

    // READ 2: Mengambil opsi pilihan satuan aktif dari view_satuan
    public function create()
    {
        $satuan = DB::table('view_satuan')->where('status', 1)->get();
        return view('barang.create', compact('satuan'));
    }

    // CREATE: Menyimpan data baru tetap ke tabel fisik via Model
    public function store(Request $request)
    {
        $request->validate([
            'jenis'    => 'required|max:1',
            'nama'     => 'required|max:45',
            'idsatuan' => 'nullable|exists:satuan,idsatuan',
            'status'   => 'required|numeric',
            'harga'    => 'required|numeric',
        ]);

        Barang::create($request->all());
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    // READ 3: Mengambil detail data barang & list satuan dari Database View
    public function edit(string $id)
    {
        $barang = DB::table('view_barang')->where('idbarang', $id)->first();

        if (!$barang) {
            abort(404, 'Data barang tidak ditemukan');
        }

        $satuan = DB::table('view_satuan')->where('status', 1)->get();
        return view('barang.edit', compact('barang', 'satuan'));
    }

    // UPDATE: Memperbarui data ke tabel fisik barang via Model
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jenis'    => 'required|max:1',
            'nama'     => 'required|max:45',
            'idsatuan' => 'nullable|exists:satuan,idsatuan',
            'status'   => 'required|numeric',
            'harga'    => 'required|numeric',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui');
    }

    // DELETE: Menghapus data dari tabel fisik barang via Model
    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }
}