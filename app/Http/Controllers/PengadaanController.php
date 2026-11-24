<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengadaanController extends Controller
{
    // READ: Membaca daftar pengadaan langsung dari SQL View v_pengadaan
    public function index()
    {
        $rows = DB::table('v_pengadaan')
            ->orderBy('idpengadaan', 'desc')
            ->get();

        //  1 pengadaan bisa memuat banyak barang
        $pengadaan = $rows->groupBy('idpengadaan')->map(function ($items) {
            $first = $items->first();
            $first->jumlah_item   = $items->count();
            $first->daftar_barang = $items->pluck('nama_barang')->implode(', ');
            return $first;
        })->values();

        return view('pengadaan.index', compact('pengadaan'));
    }

    // CREATE: Mengambil Vendor, User, dan Barang dari SQL View
    public function create()
    {
        $vendor = DB::table('view_vendor')->where('status', '1')->get();
        $user   = DB::table('view_user')->get();
        $barang = DB::table('view_barang')->where('status', 1)->get();

        return view('pengadaan.create', compact('vendor', 'user', 'barang'));
    }

    // STORE: Simpan 1 Header Pengadaan + Banyak Detail Barang sekaligus
    public function store(Request $request)
    {
        $request->validate([
            'vendor_idvendor' => 'required|exists:vendor,idvendor',
            'user_iduser'     => 'nullable|exists:user,iduser',
            'idbarang'        => 'required|array|min:1',
            'idbarang.*'      => 'required|exists:barang,idbarang',
            'jumlah'          => 'required|array|min:1',
            'jumlah.*'        => 'required|integer|min:1',
        ]);

        // Fallback petugas jika tidak dipilih
        $userId = $request->user_iduser;
        if (!$userId) {
            $firstUser = DB::table('view_user')->first();
            $userId = $firstUser ? $firstUser->iduser : 1;
        }

        DB::transaction(function () use ($request, $userId) {
            $subtotalKeseluruhan = 0;
            $itemsSiapSimpan     = [];

            foreach ($request->idbarang as $index => $idBarang) {
                $jumlah = (int) $request->jumlah[$index];

                // Acuan harga otomatis mengambil harga dasar dari view_barang
                $dataBarang = DB::table('view_barang')
                    ->where('idbarang', $idBarang)
                    ->first();

                $hargaSatuan = $dataBarang ? (int) $dataBarang->harga : 0;
                $subTotal    = $hargaSatuan * $jumlah;

                $subtotalKeseluruhan += $subTotal;

                $itemsSiapSimpan[] = [
                    'idbarang'     => $idBarang,
                    'harga_satuan' => $hargaSatuan,
                    'jumlah'       => $jumlah,
                    'sub_total'    => $subTotal,
                ];
            }

            // Hitung PPN 11% dan Total Nilai
            $ppn        = (int) round($subtotalKeseluruhan * 0.11);
            $totalNilai = $subtotalKeseluruhan + $ppn;

            // 1. Insert ke tabel pengadaan (ID otomatis) -> status awal 'P' (Proses)
            $idPengadaan = DB::table('pengadaan')->insertGetId([
                'timestamp'       => now(),
                'user_iduser'     => $userId,
                'status'          => 'P',
                'vendor_idvendor' => $request->vendor_idvendor,
                'subtotal_nilai'  => $subtotalKeseluruhan,
                'ppn'             => $ppn,
                'total_nilai'     => $totalNilai,
            ]);

            // 2. Insert banyak barang ke detail_pengadaan
            foreach ($itemsSiapSimpan as $item) {
                DB::table('detail_pengadaan')->insert([
                    'idpengadaan'  => $idPengadaan,
                    'idbarang'     => $item['idbarang'],
                    'harga_satuan' => $item['harga_satuan'],
                    'jumlah'       => $item['jumlah'],
                    'sub_total'    => $item['sub_total'],
                ]);
            }
        });

        return redirect()->route('pengadaan.index')
            ->with('success', 'Transaksi pengadaan multi-barang berhasil disimpan!');
    }

    // SHOW: Menampilkan detail semua barang dalam 1 pengadaan dari v_pengadaan
    public function show(string $id)
    {
        $details = DB::table('v_pengadaan')
            ->where('idpengadaan', $id)
            ->get();

        abort_if($details->isEmpty(), 404);

        $header = $details->first();

        return view('pengadaan.show', compact('header', 'details'));
    }
}