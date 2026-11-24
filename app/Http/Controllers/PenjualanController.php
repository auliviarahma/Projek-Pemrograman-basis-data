<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class PenjualanController extends Controller
{
    // READ: Daftar riwayat penjualan
    public function index()
    {
        $penjualan = DB::table('v_penjualan')
            ->orderBy('idpenjualan', 'desc')
            ->get();

        return view('penjualan.index', compact('penjualan'));
    }

    // CREATE: Menyiapkan data untuk form Kasir Penjualan
    public function create()
    {
        $users = DB::table('view_user')->get();

        $marginAktif = DB::table('margin_penjualan')
            ->where('status', 1)
            ->first();

        // Ambil barang aktif + hitung harga_jual via SQL Function + ambil stok terakhir dari kartu_stok
        $barangs = DB::table('view_barang as b')
            ->select(
                'b.idbarang',
                'b.nama as nama_barang',
                DB::raw('hitung_harga_jual(b.idbarang) as harga_jual'),
                DB::raw('COALESCE((SELECT stock FROM kartu_stok WHERE idbarang = b.idbarang ORDER BY idkartu_stok DESC LIMIT 1), 0) as stok_tersedia')
            )
            ->where('b.status', 1)
            ->get();

        return view('penjualan.create', compact('users', 'marginAktif', 'barangs'));
    }

    // STORE: Simpan transaksi penjualan multi-barang menggunakan Stored Function
    public function store(Request $request)
    {
        // 1. Validasi array multi-barang sesuai form Blade
        $request->validate([
            'iduser'     => 'nullable|integer|exists:user,iduser',
            'idbarang'   => 'required|array|min:1',
            'idbarang.*' => 'required|integer|exists:barang,idbarang',
            'jumlah'     => 'required|array|min:1',
            'jumlah.*'   => 'required|integer|min:1',
        ]);

        // Ambil user & margin aktif
        $userId = $request->iduser ?? (auth()->id() ?? (DB::table('view_user')->value('iduser') ?? 1));
        $marginAktif = DB::table('margin_penjualan')->where('status', 1)->first();

        if (!$marginAktif) {
            return redirect()->back()->withInput()->with('error', 'Tidak ada Margin Penjualan yang aktif!');
        }

        DB::beginTransaction();
        try {
            $subtotalKeseluruhan = 0;
            $itemsSiapSimpan     = [];

            // 2. Hitung harga jual & subtotal tiap item menggunakan Stored Function SQL
            foreach ($request->idbarang as $index => $idBarang) {
                $jumlah = (int) $request->jumlah[$index];

                $hasil = DB::selectOne(
                    'SELECT 
                        hitung_harga_jual(?) AS harga_jual, 
                        hitung_subtotal_penjualan(?, ?) AS subtotal',
                    [$idBarang, $idBarang, $jumlah]
                );

                $hargaSatuan = (int) round($hasil->harga_jual);
                $subTotal    = (int) round($hasil->subtotal);

                $subtotalKeseluruhan += $subTotal;

                $itemsSiapSimpan[] = [
                    'idbarang'     => $idBarang,
                    'harga_satuan' => $hargaSatuan,
                    'jumlah'       => $jumlah,
                    'subtotal'     => $subTotal,
                ];
            }

            // Hitung PPN 11% dan Total Bayar sesuai tampilan di Blade
            $ppn        = (int) round($subtotalKeseluruhan * 0.11);
            $totalNilai = $subtotalKeseluruhan + $ppn;

            // 3. Simpan header transaksi ke tabel penjualan
            // (Sesuaikan nama kolom jika di tabel penjualan milikmu berbeda)
            $idpenjualan = DB::table('penjualan')->insertGetId([
                'created_at'         => now(),
                'subtotal_nilai'     => $subtotalKeseluruhan,
                'ppn'                => $ppn,
                'total_nilai'        => $totalNilai,
                'iduser'             => $userId,
                'idmargin_penjualan' => $marginAktif->idmargin_penjualan,
            ]);

            // 4. Simpan detail penjualan multi-barang
            // Trigger 'trg_cek_stok_sebelum_jual' & 'trg_penjualan_kurang_stok' berjalan per baris insert
            foreach ($itemsSiapSimpan as $item) {
                DB::table('detail_penjualan')->insert([
                    'penjualan_idpenjualan' => $idpenjualan,
                    'idbarang'              => $item['idbarang'],
                    'jumlah'                => $item['jumlah'],
                    'harga_satuan'          => $item['harga_satuan'],
                    'subtotal'              => $item['subtotal'],
                ]);
            }

            DB::commit();

            return redirect()->route('penjualan.index')
                ->with('success', 'Transaksi penjualan berhasil disimpan dan stok otomatis berkurang!');

        } catch (QueryException $e) {
            DB::rollBack();

            $errorCode = $e->getCode();
            if ($errorCode == '45000') {
                return redirect()->back()->withInput()->with('error', $e->errorInfo[2] ?? 'Stok barang tidak mencukupi!');
            }

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}