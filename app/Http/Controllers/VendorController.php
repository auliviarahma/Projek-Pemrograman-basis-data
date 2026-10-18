<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Ditambahkan untuk query Database View

class VendorController extends Controller
{
    // READ 1: Menampilkan daftar data vendor langsung dari Database View (view_vendor)
    public function index()
    {
        $vendor = DB::table('view_vendor')->get();
        return view('vendor.index', compact('vendor'));
    }

    public function create()
    {
        return view('vendor.create');
    }

    // CREATE: Menyimpan data baru tetap ke tabel fisik vendor via Model
    public function store(Request $request)
    {
        $request->validate([
            'nama_vendor' => 'required|max:100',
            'badan_hukum' => 'required|max:1',
            'status'      => 'required|max:1',
        ]);

        Vendor::create($request->all());
        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil ditambahkan');
    }

    // READ 2: Mengambil detail data vendor dari Database View (view_vendor)
    public function edit(string $id)
    {
        $vendor = DB::table('view_vendor')->where('idvendor', $id)->first();

        if (!$vendor) {
            abort(404, 'Data vendor tidak ditemukan');
        }

        return view('vendor.edit', compact('vendor'));
    }

    // UPDATE: Memperbarui data pada tabel fisik vendor via Model
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_vendor' => 'required|max:100',
            'badan_hukum' => 'required|max:1',
            'status'      => 'required|max:1',
        ]);

        $vendor = Vendor::findOrFail($id);
        $vendor->update($request->all());
        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil diperbarui');
    }

    // DELETE: Menghapus data dari tabel fisik vendor via Model
    public function destroy(string $id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();
        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil dihapus');
    }
}