<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Satuan;
use App\Models\Barang;
use App\Models\Vendor;
use App\Models\Role;
use App\Models\User;
use App\Models\MarginPenjualan;

use App\Http\Controllers\SatuanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarginPenjualanController;

// ==========================================
// 1. DASHBOARD UTAMA
// ==========================================
Route::get('/', function () {
    $totalSatuan = Satuan::count();$totalBarang = Barang::count();
    $totalVendor = Vendor::count();$totalRole   = Role::count();
    $totalUser   = User::count();$totalMargin = MarginPenjualan::count();

    return view('dashboard', compact(
        'totalSatuan', 
        'totalBarang', 
        'totalVendor', 
        'totalRole', 
        'totalUser', 
        'totalMargin'
    ));
})->name('dashboard');

// ==========================================
// 2. MASTER DATA CRUD & STORED PROCEDURE
// ==========================================
Route::resource('satuan', SatuanController::class);
Route::resource('barang', BarangController::class);
Route::resource('vendor', VendorController::class);
Route::resource('role', RoleController::class);
Route::resource('user', UserController::class);

Route::post('margin-penjualan/{id}/aktifkan', [MarginPenjualanController::class, 'aktifkan'])
    ->name('margin-penjualan.aktifkan');
Route::resource('margin-penjualan', MarginPenjualanController::class);

Route::redirect('/margin', '/margin-penjualan');
Route::redirect('/margin_penjualan', '/margin-penjualan');

// ==========================================
// 3. BUKU BESAR KARTU STOK (MEMBACA TRIGGER)
// ==========================================
Route::get('kartu-stok', function () {
    $kartuStok = DB::table('kartu_stok')
        ->join('barang', 'kartu_stok.idbarang', '=', 'barang.idbarang')
        ->select(
            'kartu_stok.idkartu_stok',
            'kartu_stok.created_at',
            'barang.nama as nama_barang',
            'kartu_stok.jenis_transaksi',
            'kartu_stok.masuk',
            'kartu_stok.keluar',
            'kartu_stok.stock',
            'kartu_stok.idtransaksi'
        )
        ->orderBy('kartu_stok.idkartu_stok', 'desc')
        ->get();

    return view('kartu_stok', compact('kartuStok'));
})->name('kartu-stok.index');

// ==========================================
// 4. TRANSAKSI PENGADAAN (DILENGKAPI USER)
// ==========================================
Route::get('pengadaan', function () {
    $dataPengadaan = DB::table('pengadaan')
        ->leftJoin('vendor', 'pengadaan.vendor_idvendor', '=', 'vendor.idvendor')
        ->leftJoin('user', 'pengadaan.user_iduser', '=', 'user.iduser')
        ->select(
            'pengadaan.*',
            'vendor.nama_vendor',
            'user.username'
        )
        ->orderBy('pengadaan.idpengadaan', 'desc')
        ->get();

    return view('pengadaan.index', compact('dataPengadaan'));
})->name('pengadaan.index');

Route::get('pengadaan/create', function () {
    $vendors = DB::table('vendor')->get();
    $barangs = DB::table('barang')->get();$users   = DB::table('user')->get();

    return view('pengadaan.create', compact('vendors', 'barangs', 'users'));
})->name('pengadaan.create');

Route::post('pengadaan/store', function (Request $request) {
    try {
        DB::transaction(function () use ($request) {
            $jumlah = (int)$request->jumlah;
            $harga = (int)$request->harga_satuan;
            $subtotal = $jumlah * $harga;
            $ppn = (int) ($subtotal * 0.11);$total = $subtotal +$ppn;

            $userId =$request->iduser;
            if (!$userId) {
                $firstUser = DB::table('user')->first();$userId = $firstUser ? $firstUser->iduser : 1;
            }

            $idpengadaan = DB::table('pengadaan')->insertGetId([
                'timestamp'       => now(),
                'status'          => '1',
                'subtotal_nilai'  => $subtotal,
                'ppn'             => $ppn,
                'total_nilai'     => $total,
                'user_iduser'     => $userId,
                'vendor_idvendor' => $request->idvendor
            ]);

            DB::table('detail_pengadaan')->insert([
                'idpengadaan'  => $idpengadaan,
                'idbarang'     => $request->idbarang,
                'jumlah'       => $jumlah,
                'harga_satuan' => $harga,
                'sub_total'    => $subtotal
            ]);
        });

        return redirect()->route('pengadaan.index')->with('success', 'Pengadaan berhasil dibuat!');
    } catch (\Exception $e) {
        return back()->withInput()->with('error', 'Gagal menyimpan pengadaan: ' . $e->getMessage());
    }
})->name('pengadaan.store');

// ==========================================
// 5. TRANSAKSI PENERIMAAN (TERPADU & USER)
// ==========================================
Route::get('penerimaan', function () {
    $headerPenerimaan = DB::table('penerimaan')
        ->leftJoin('pengadaan', 'penerimaan.idpengadaan', '=', 'pengadaan.idpengadaan')
        ->leftJoin('vendor', 'pengadaan.vendor_idvendor', '=', 'vendor.idvendor')
        ->leftJoin('user', 'penerimaan.iduser', '=', 'user.iduser')
        ->select(
            'penerimaan.idpenerimaan',
            'penerimaan.created_at',
            'penerimaan.status',
            'penerimaan.idpengadaan',
            'vendor.nama_vendor',
            'pengadaan.total_nilai',
            'user.username'
        )
        ->orderBy('penerimaan.idpenerimaan', 'desc')
        ->get();

    $pengadaans = DB::table('pengadaan')
        ->leftJoin('vendor', 'pengadaan.vendor_idvendor', '=', 'vendor.idvendor')
        ->select('pengadaan.*', 'vendor.nama_vendor')
        ->orderBy('pengadaan.idpengadaan', 'desc')
        ->get();

    foreach ($pengadaans as $po) {$totalPesan = DB::table('detail_pengadaan')
            ->where('idpengadaan', $po->idpengadaan)
            ->sum('jumlah');

        $totalTerima = DB::table('detail_penerimaan')
            ->join('penerimaan', 'detail_penerimaan.idpenerimaan', '=', 'penerimaan.idpenerimaan')
            ->where('penerimaan.idpengadaan', $po->idpengadaan)
            ->sum('detail_penerimaan.jumlah_terima');

        $po->is_selesai = ($totalPesan > 0 && $totalTerima >=$totalPesan);
    }

    $users = DB::table('user')->get();

    return view('penerimaan.index', compact('headerPenerimaan', 'pengadaans', 'users'));
})->name('penerimaan.index');

Route::post('penerimaan/store', function (Request $request) {
    try {
        if (!$request->idpengadaan) {
            return back()->with('error', 'Silakan pilih nomor pengadaan terlebih dahulu!');
        }

        $userId =$request->iduser;
        if (!$userId) {
            $firstUser = DB::table('user')->first();$userId = $firstUser ? $firstUser->iduser : 1;
        }

        $idpenerimaan = DB::table('penerimaan')->insertGetId([
            'created_at'  => now(),
            'status'      => 'F',
            'idpengadaan' => $request->idpengadaan,
            'iduser'      => $userId
        ]);

        return redirect()->route('penerimaan.detail', $idpenerimaan)->with('success', 'Header penerimaan berhasil dibuat! Silakan input detail barang.');
    } catch (\Exception $e) {
        return back()->withInput()->with('error', 'Gagal membuat penerimaan: ' . $e->getMessage());
    }
})->name('penerimaan.store');

Route::get('penerimaan/{id}/detail', function ($id) {$penerimaan = DB::table('penerimaan')
        ->leftJoin('pengadaan', 'penerimaan.idpengadaan', '=', 'pengadaan.idpengadaan')
        ->leftJoin('vendor', 'pengadaan.vendor_idvendor', '=', 'vendor.idvendor')
        ->leftJoin('user', 'penerimaan.iduser', '=', 'user.iduser')
        ->select(
            'penerimaan.*',
            'pengadaan.timestamp as tgl_pengadaan',
            'pengadaan.subtotal_nilai',
            'pengadaan.ppn',
            'pengadaan.total_nilai',
            'vendor.nama_vendor',
            'user.username'
        )
        ->where('penerimaan.idpenerimaan', $id)
        ->first();

    if (!$penerimaan) {
        return redirect()->route('penerimaan.index')->with('error', 'Data penerimaan tidak ditemukan.');
    }

    $details = DB::table('detail_penerimaan')
        ->join('barang', 'detail_penerimaan.barang_idbarang', '=', 'barang.idbarang')
        ->select('detail_penerimaan.*', 'barang.nama as nama_barang')
        ->where('detail_penerimaan.idpenerimaan', $id)
        ->orderBy('detail_penerimaan.iddetail_penerimaan', 'asc')
        ->get();

    $barangsPO = DB::table('detail_pengadaan')
        ->join('barang', 'detail_pengadaan.idbarang', '=', 'barang.idbarang')
        ->where('detail_pengadaan.idpengadaan', $penerimaan->idpengadaan)
        ->select('barang.idbarang', 'barang.nama', 'detail_pengadaan.jumlah as jumlah_pesan')
        ->get();

    foreach ($barangsPO as $b) {$totalSudahTerima = DB::table('detail_penerimaan')
            ->join('penerimaan', 'detail_penerimaan.idpenerimaan', '=', 'penerimaan.idpenerimaan')
            ->where('penerimaan.idpengadaan', $penerimaan->idpengadaan)
            ->where('detail_penerimaan.barang_idbarang', $b->idbarang)
            ->sum('detail_penerimaan.jumlah_terima');

        $b->sisa_kuota = max(0, $b->jumlah_pesan -$totalSudahTerima);
    }

    return view('penerimaan.detail', compact('penerimaan', 'details', 'barangsPO'));
})->name('penerimaan.detail');

Route::post('penerimaan/{id}/detail/store', function (Request $request,$id) {
    try {
        $penerimaan = DB::table('penerimaan')->where('idpenerimaan',$id)->first();
        if (!$penerimaan) {
            return back()->with('error', 'Transaksi penerimaan tidak valid.');
        }

        $idbarang =$request->idbarang;
        $jumlahTerima = (int)$request->jumlah_terima;
        $hargaTerima = (int)$request->harga_satuan_terima;

        $detailPO = DB::table('detail_pengadaan')
            ->where('idpengadaan', $penerimaan->idpengadaan)
            ->where('idbarang', $idbarang)
            ->first();

        if (!$detailPO) {
            return back()->with('error', 'Barang ini tidak ada dalam daftar PO Pengadaan #' . $penerimaan->idpengadaan . '! Tidak dapat diterima.');
        }

        $totalSudahDiterima = DB::table('detail_penerimaan')
            ->join('penerimaan', 'detail_penerimaan.idpenerimaan', '=', 'penerimaan.idpenerimaan')
            ->where('penerimaan.idpengadaan', $penerimaan->idpengadaan)
            ->where('detail_penerimaan.barang_idbarang', $idbarang)
            ->sum('detail_penerimaan.jumlah_terima');

        $sisaBolehDiterima = $detailPO->jumlah -$totalSudahDiterima;

        if ($jumlahTerima >$sisaBolehDiterima) {
            return back()->with('error', "Jumlah penerimaan ({$jumlahTerima}) melebihi kuota pesanan! Sisa pesanan di PO hanya {$sisaBolehDiterima}.");
        }

        $subtotal = $jumlahTerima * $hargaTerima;

        DB::table('detail_penerimaan')->insert([
            'idpenerimaan'        => $id,
            'barang_idbarang'     => $idbarang,
            'jumlah_terima'       => $jumlahTerima,
            'harga_satuan_terima' => $hargaTerima,
            'sub_total_terima'    => $subtotal
        ]);

        return back()->with('success', 'Barang berhasil diterima dan mutasi stok otomatis bertambah!');
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal memproses penerimaan: ' . $e->getMessage());
    }
})->name('penerimaan.detail.store');

Route::get('penerimaan/{id}/edit', function ($id) {
    $penerimaan = DB::table('penerimaan')->where('idpenerimaan',$id)->first();
    if (!$penerimaan) {
        return redirect()->route('penerimaan.index')->with('error', 'Data tidak ditemukan.');
    }

    $pengadaans = DB::table('pengadaan')
        ->leftJoin('vendor', 'pengadaan.vendor_idvendor', '=', 'vendor.idvendor')
        ->select('pengadaan.*', 'vendor.nama_vendor')
        ->orderBy('pengadaan.idpengadaan', 'desc')
        ->get();

    $users = DB::table('user')->get();

    return view('penerimaan.edit', compact('penerimaan', 'pengadaans', 'users'));
})->name('penerimaan.edit');

Route::put('penerimaan/{id}/update', function (Request $request,$id) {
    try {
        DB::table('penerimaan')
            ->where('idpenerimaan', $id)
            ->update([
                'idpengadaan' => $request->idpengadaan,
                'iduser'      => $request->iduser,
                'status'      => $request->status ?? 'F'
            ]);

        return redirect()->route('penerimaan.detail', $id)->with('success', 'Header penerimaan berhasil diperbarui!');
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal memperbarui: ' . $e->getMessage());
    }
})->name('penerimaan.update');

Route::delete('penerimaan/{id}/destroy', function ($id) {
    try {
        DB::transaction(function () use ($id) {
            DB::table('detail_penerimaan')->where('idpenerimaan', $id)->delete();
            DB::table('penerimaan')->where('idpenerimaan', $id)->delete();
        });

        return redirect()->route('penerimaan.index')->with('success', 'Transaksi penerimaan berhasil dihapus!');
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal menghapus penerimaan: ' . $e->getMessage());
    }
})->name('penerimaan.destroy');

Route::delete('penerimaan/detail/{iddetail}/destroy', function ($iddetail) {
    try {
        $detail = DB::table('detail_penerimaan')->where('iddetail_penerimaan',$iddetail)->first();
        if ($detail) {
            DB::table('detail_penerimaan')->where('iddetail_penerimaan', $iddetail)->delete();
            return back()->with('success', 'Item barang berhasil dihapus dari detail penerimaan.');
        }
        return back()->with('error', 'Data detail tidak ditemukan.');
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal menghapus item: ' . $e->getMessage());
    }
})->name('penerimaan.detail.destroy');