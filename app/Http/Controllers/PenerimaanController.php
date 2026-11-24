<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenerimaanController extends Controller
{
    public function index()
    {
        $penerimaan = DB::table('penerimaan as pn')
            ->join('pengadaan as pg', 'pn.idpengadaan', '=', 'pg.idpengadaan')
            ->join('vendor as v', 'pg.vendor_idvendor', '=', 'v.idvendor')
            ->join('user as u', 'pn.iduser', '=', 'u.iduser')
            ->select(
                'pn.*',
                'v.nama_vendor',
                'u.username'
            )
            ->orderBy('pn.idpenerimaan', 'desc')
            ->get();

        return view('penerimaan.index', compact('penerimaan'));
    }

    public function create()
    {
        // Ambil pengadaan yang masih aktif / diproses (status = 'P' atau '1')
        $pengadaan = DB::table('pengadaan as pg')
            ->join('vendor as v', 'pg.vendor_idvendor', '=', 'v.idvendor')
            ->whereIn('pg.status', ['P', '1', 1])
            ->select('pg.*', 'v.nama_vendor')
            ->orderBy('pg.idpengadaan', 'desc')
            ->get();

        return view('penerimaan.create', compact('pengadaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idpengadaan' => 'required|integer',
        ]);

        $iduser = Auth::id() ?? session('iduser') ?? 1;

        $idpenerimaan = DB::table('penerimaan')->insertGetId([
            'created_at'  => now(),
            'status'      => 'P',
            'idpengadaan' => $request->idpengadaan,
            'iduser'      => $iduser,
        ]);

        return redirect()->route('penerimaan.detail', $idpenerimaan)
            ->with('success', 'Header penerimaan berhasil dibuat. Silakan input detail barang diterima.');
    }

    public function detail($id)
    {
        // 1. Ambil header penerimaan
        $penerimaan = DB::table('penerimaan as pn')
            ->join('pengadaan as pg', 'pn.idpengadaan', '=', 'pg.idpengadaan')
            ->join('vendor as v', 'pg.vendor_idvendor', '=', 'v.idvendor')
            ->join('user as u', 'pn.iduser', '=', 'u.iduser')
            ->where('pn.idpenerimaan', $id)
            ->select('pn.*', 'pg.idpengadaan', 'v.nama_vendor', 'u.username')
            ->first();

        if (!$penerimaan) {
            return redirect()->route('penerimaan.index')->with('error', 'Data penerimaan tidak ditemukan.');
        }

        // 2. Ambil daftar barang berdasarkan item yang dipesan pada pengadaan terkait
        //    beserta harga_satuan dari detail_pengadaan & hitung sisa kuota yang belum diterima
        $barang = DB::table('detail_pengadaan as dp')
            ->join('barang as b', 'dp.idbarang', '=', 'b.idbarang')
            ->leftJoin('satuan as s', 'b.idsatuan', '=', 's.idsatuan')
            ->where('dp.idpengadaan', $penerimaan->idpengadaan)
            ->select(
                'b.idbarang',
                'b.nama as nama_barang',
                's.nama_satuan',
                'dp.harga_satuan',
                'dp.jumlah as jumlah_pesan',
                DB::raw('(SELECT COALESCE(SUM(dpr.jumlah_terima), 0)
                          FROM detail_penerimaan dpr
                          JOIN penerimaan pnr ON dpr.idpenerimaan = pnr.idpenerimaan
                          WHERE pnr.idpengadaan = dp.idpengadaan
                            AND dpr.barang_idbarang = dp.idbarang) as sudah_diterima')
            )
            ->get();

        // 3. Ambil daftar item yang sudah dimasukkan ke nota penerimaan ini
        $details = DB::table('detail_penerimaan as dpr')
            ->join('barang as b', 'dpr.barang_idbarang', '=', 'b.idbarang')
            ->leftJoin('satuan as s', 'b.idsatuan', '=', 's.idsatuan')
            ->where('dpr.idpenerimaan', $id)
            ->select(
                'dpr.*',
                'b.nama as nama_barang',
                's.nama_satuan'
            )
            ->get();

        return view('penerimaan.detail', compact('penerimaan', 'barang', 'details'));
    }

    public function storeDetail(Request $request)
    {
        $request->validate([
            'idpenerimaan'    => 'required|integer',
            'barang_idbarang' => 'required|integer',
            'jumlah_terima'   => 'required|integer|min:1',
            'harga_satuan'    => 'required|numeric|min:0',
        ]);

        try {
            // Trigger trg_penerimaan_tambah_stok otomatis mencatat ke kartu_stok & update harga di master barang
            DB::table('detail_penerimaan')->insert([
                'idpenerimaan'     => $request->idpenerimaan,
                'barang_idbarang'  => $request->barang_idbarang,
                'jumlah_terima'    => $request->jumlah_terima,
                'harga_satuan'     => $request->harga_satuan,
                'sub_total_terima' => $request->jumlah_terima * $request->harga_satuan,
            ]);

            return redirect()->back()->with('success', 'Penerimaan barang berhasil dicatat, kartu stok & harga barang diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses penerimaan: ' . $e->getMessage());
        }
    }
}