<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class PenjualanController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi input form
        $request->validate([
            'idbarang' => 'required|integer',
            'jumlah'   => 'required|integer|min:1',
            'harga'    => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            // 2. Buat header transaksi penjualan jika belum ada
            $idpenjualan = DB::table('penjualan')->insertGetId([
                'iduser'     => auth()->id() ?? 1,
                'created_at' => now(),
                'subtotal'   => $request->jumlah * $request->harga,
            ]);

            // 3. Simpan detail penjualan
            // Pada baris ini, trigger 'trg_cek_stok_sebelum_jual' & 'trg_penjualan_kurang_stok' otomatis bekerja!
            DB::table('detail_penjualan')->insert([
                'penjualan_idpenjualan' => $idpenjualan,
                'idbarang'              => $request->idbarang,
                'jumlah'                => $request->jumlah,
                'harga_satuan'          => $request->harga,
                'subtotal'              => $request->jumlah * $request->harga,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Transaksi penjualan berhasil disimpan dan stok otomatis berkurang!');

        } catch (QueryException $e) {
            DB::rollBack();

            // Tangkap pesan error dari SIGNAL SQLSTATE '45000' milik trigger
            $errorCode = $e->getCode();
            if ($errorCode == '45000') {
                // Mengambil pesan text trigger (contoh: "Gagal menyimpan transaksi: Stok barang tidak mencukupi!")
                return redirect()->back()->withInput()->with('error', $e->errorInfo[2] ?? 'Stok barang tidak mencukupi!');
            }

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}