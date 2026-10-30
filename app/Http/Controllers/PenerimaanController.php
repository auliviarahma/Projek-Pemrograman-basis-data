public function storeDetail(Request $request)
{
    $request->validate([
        'idpenerimaan'    => 'required|integer',
        'barang_idbarang' => 'required|integer',
        'jumlah_terima'   => 'required|integer|min:1',
        'harga_satuan'    => 'required|numeric',
    ]);

    try {
        // Trigger trg_penerimaan_tambah_stok otomatis mencatat jenis 'M' di kartu_stok
        DB::table('detail_penerimaan')->insert([
            'idpenerimaan'    => $request->idpenerimaan,
            'barang_idbarang' => $request->barang_idbarang,
            'jumlah_terima'   => $request->jumlah_terima,
            'harga_satuan'    => $request->harga_satuan,
            'sub_total_terima'=> $request->jumlah_terima * $request->harga_satuan,
        ]);

        return redirect()->back()->with('success', 'Penerimaan barang berhasil dicatat, kartu stok bertambah!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal memproses penerimaan: ' . $e->getMessage());
    }
}