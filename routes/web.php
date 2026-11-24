<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
// 0. AUTENTIKASI LOGIN & LOGOUT
// ==========================================
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $user = User::where('username', $request->username)->first();

    $passwordValid = false;
    if ($user) {
        if ($request->password === $user->password) {
            $passwordValid = true;
        } elseif (str_starts_with($user->password, '$2y$') && Hash::check($request->password, $user->password)) {
            $passwordValid = true;
        }
    }

    if ($passwordValid) {
        $namaRole  = DB::table('role')->where('idrole', $user->idrole)->value('nama_role');
        $roleLower = strtolower(trim($namaRole ?? ''));

        if (!in_array($roleLower, ['super admin', 'kasir'])) {
            return back()->withInput()->with('error', 'Role "' . $namaRole . '" tidak memiliki akses login ke sistem.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))
            ->with('success', 'Selamat datang, ' . $user->username . ' (' . $namaRole . ')!');
    }

    return back()->withInput()->with('error', 'Username atau password salah!');
})->name('login.post');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
})->name('logout');

// ==========================================
// RUTE TERPROTEKSI LOGIN (SUPER ADMIN & KASIR)
// ==========================================
Route::middleware(['auth'])->group(function () {

    // ==========================================
    // 1. DASHBOARD UTAMA (SEMUA ROLE LOGIN)
    // ==========================================
    Route::get('/', function () {
        $totalSatuan = Satuan::count();
        $totalBarang = Barang::count();
        $totalVendor = Vendor::count();
        $totalRole   = Role::count();
        $totalUser   = User::count();
        $totalMargin = MarginPenjualan::count();

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
    // 2. BUKU BESAR KARTU STOK (SEMUA ROLE LOGIN)
    // ==========================================
    Route::get('kartu-stok', function () {
        $kartuStok = DB::table('view_kartu_stok')
            ->orderBy('idkartu_stok', 'desc')
            ->get();

        return view('kartu_stok', compact('kartuStok'));
    })->name('kartu-stok.index');

    // ==========================================
    // 3. TRANSAKSI PENJUALAN (KASIR & SUPER ADMIN)
    // ==========================================
    Route::get('penjualan', function () {
        $penjualans = DB::table('penjualan')
            ->leftJoin('user', 'penjualan.iduser', '=', 'user.iduser')
            ->leftJoin('margin_penjualan', 'penjualan.idmargin_penjualan', '=', 'margin_penjualan.idmargin_penjualan')
            ->select(
                'penjualan.*',
                'user.username',
                'margin_penjualan.persen as margin_persen'
            )
            ->orderBy('penjualan.idpenjualan', 'desc')
            ->get();

        return view('penjualan.index', compact('penjualans'));
    })->name('penjualan.index');

    Route::get('penjualan/create', function () {
        // Mengambil harga_satuan langsung dari Stored Function hitung_harga_jual(idbarang)
        $barangs = DB::table('view_barang')
            ->where('status', 1)
            ->select(
                'view_barang.*',
                DB::raw('hitung_harga_jual(idbarang) as harga_jual')
            )
            ->get();

        // Cek stok terakhir tiap barang melalui SQL View view_kartu_stok
        foreach ($barangs as $b) {
            $lastStok = DB::table('view_kartu_stok')
                ->where('idbarang', $b->idbarang)
                ->orderBy('idkartu_stok', 'desc')
                ->value('stock');
            $b->stok_tersedia = $lastStok ?? 0;
        }

        $marginAktif = DB::table('view_margin_penjualan')->where('status', 1)->first();
        $users       = DB::table('user')->get();

        return view('penjualan.create', compact('barangs', 'marginAktif', 'users'));
    })->name('penjualan.create');

    Route::post('penjualan/store', function (Request $request) {
        try {
            DB::transaction(function () use ($request) {
                $marginAktif = DB::table('view_margin_penjualan')->where('status', 1)->first();
                if (!$marginAktif) {
                    throw new \Exception('Belum ada margin penjualan yang aktif! Aktifkan salah satu margin terlebih dahulu.');
                }

                // Prioritaskan user yang sedang login, fallback ke input form
                $userId = Auth::id() ?? $request->iduser;
                if (!$userId) {
                    $firstUser = DB::table('user')->first();
                    $userId = $firstUser ? $firstUser->iduser : 1;
                }

                $idBarangs = is_array($request->idbarang) ? $request->idbarang : [$request->idbarang];
                $jumlahs   = is_array($request->jumlah) ? $request->jumlah : [$request->jumlah];

                $subtotalKeseluruhan = 0;
                $itemsSiapSimpan     = [];

                foreach ($idBarangs as $i => $idBarang) {
                    if (!$idBarang) continue;
                    $qty = (int) ($jumlahs[$i] ?? 1);

                    // Memanggil Stored Function harga_satuan & sub_total langsung dari MySQL
                    $calc = DB::selectOne(
                        'SELECT hitung_harga_jual(?) AS harga_satuan, hitung_subtotal_penjualan(?, ?) AS sub_total',
                        [$idBarang, $idBarang, $qty]
                    );

                    $hargaSatuan = (int) round($calc->harga_satuan);
                    $subTotal    = (int) round($calc->sub_total);

                    $subtotalKeseluruhan += $subTotal;
                    $itemsSiapSimpan[] = [
                        'idbarang'     => $idBarang,
                        'jumlah'       => $qty,
                        'harga_satuan' => $hargaSatuan,
                        'sub_total'    => $subTotal,
                    ];
                }

                $ppn   = (int) round($subtotalKeseluruhan * 0.11);
                $total = $subtotalKeseluruhan + $ppn;

                // Insert header penjualan (status hanya ada 1 yaitu 'S' = Selesai)
                $idpenjualan = DB::table('penjualan')->insertGetId([
                    'created_at'         => now(),
                    'subtotal_nilai'     => $subtotalKeseluruhan,
                    'ppn'                => $ppn,
                    'total_nilai'        => $total,
                    'iduser'             => $userId,
                    'idmargin_penjualan' => $marginAktif->idmargin_penjualan,
                ]);

                // Insert detail_penjualan -> memicu Trigger cek stok via view_kartu_stok (SQLSTATE 45000) & potong stok
                foreach ($itemsSiapSimpan as $item) {
                    DB::table('detail_penjualan')->insert([
                        'penjualan_idpenjualan' => $idpenjualan,
                        'idbarang'              => $item['idbarang'],
                        'harga_satuan'          => $item['harga_satuan'],
                        'jumlah'                => $item['jumlah'],
                        'sub_total'             => $item['sub_total'],
                    ]);
                }
            });

            return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil disimpan (Selesai) dan stok otomatis berkurang!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal memproses penjualan: ' . $e->getMessage());
        }
    })->name('penjualan.store');

    Route::get('penjualan/{id}/detail', function ($id) {
        $penjualan = DB::table('penjualan')
            ->leftJoin('user', 'penjualan.iduser', '=', 'user.iduser')
            ->leftJoin('margin_penjualan', 'penjualan.idmargin_penjualan', '=', 'margin_penjualan.idmargin_penjualan')
            ->select(
                'penjualan.*',
                'user.username',
                'margin_penjualan.persen as margin_persen'
            )
            ->where('penjualan.idpenjualan', $id)
            ->first();

        if (!$penjualan) {
            return redirect()->route('penjualan.index')->with('error', 'Data penjualan tidak ditemukan.');
        }

        $details = DB::table('detail_penjualan')
            ->join('barang', 'detail_penjualan.idbarang', '=', 'barang.idbarang')
            ->select('detail_penjualan.*', 'barang.nama as nama_barang')
            ->where('detail_penjualan.penjualan_idpenjualan', $id)
            ->get();

        return view('penjualan.detail', compact('penjualan', 'details'));
    })->name('penjualan.detail');

    // ==========================================
    // 4. HAK AKSES KHUSUS SUPER ADMIN
    // ==========================================
    Route::middleware(['superadmin'])->group(function () {

        // MASTER DATA CRUD & STORED PROCEDURE
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

        // TRANSAKSI PENGADAAN (MULTI-BARANG & V_PENGADAAN)
        Route::get('pengadaan', function () {
            $rows = DB::table('v_pengadaan')
                ->orderBy('idpengadaan', 'desc')
                ->get();

            $dataPengadaan = $rows->groupBy('idpengadaan')->map(function ($items) {
                $first = $items->first();
                $first->daftar_barang = $items->pluck('nama_barang')->implode(', ');
                $first->jumlah_item   = $items->count();
                return $first;
            })->values();

            return view('pengadaan.index', compact('dataPengadaan'));
        })->name('pengadaan.index');

        Route::get('pengadaan/create', function () {
            $vendors = DB::table('vendor')->where('status', '1')->get();
            $barangs = DB::table('view_barang')->where('status', 1)->get();
            $users   = DB::table('user')->get();

            return view('pengadaan.create', compact('vendors', 'barangs', 'users'));
        })->name('pengadaan.create');

        Route::post('pengadaan/store', function (Request $request) {
            try {
                DB::transaction(function () use ($request) {
                    $idBarangs = is_array($request->idbarang) ? $request->idbarang : [$request->idbarang];
                    $jumlahs   = is_array($request->jumlah) ? $request->jumlah : [$request->jumlah];

                    $subtotalKeseluruhan = 0;
                    $itemsSiapSimpan     = [];

                    foreach ($idBarangs as $i => $idBarang) {
                        if (!$idBarang) continue;
                        $qty = (int) ($jumlahs[$i] ?? 1);

                        $barangMaster = DB::table('view_barang')->where('idbarang', $idBarang)->first();
                        $harga        = $barangMaster ? (int) $barangMaster->harga : 0;
                        $sub          = $qty * $harga;

                        $subtotalKeseluruhan += $sub;
                        $itemsSiapSimpan[] = [
                            'idbarang'     => $idBarang,
                            'jumlah'       => $qty,
                            'harga_satuan' => $harga,
                            'sub_total'    => $sub,
                        ];
                    }

                    $ppn   = (int) round($subtotalKeseluruhan * 0.11);
                    $total = $subtotalKeseluruhan + $ppn;

                    $userId = Auth::id() ?? $request->iduser;
                    if (!$userId) {
                        $firstUser = DB::table('user')->first();
                        $userId = $firstUser ? $firstUser->iduser : 1;
                    }

                    $idpengadaan = DB::table('pengadaan')->insertGetId([
                        'timestamp'       => now(),
                        'status'          => 'P',
                        'subtotal_nilai'  => $subtotalKeseluruhan,
                        'ppn'             => $ppn,
                        'total_nilai'     => $total,
                        'user_iduser'     => $userId,
                        'vendor_idvendor' => $request->idvendor
                    ]);

                    foreach ($itemsSiapSimpan as $item) {
                        DB::table('detail_pengadaan')->insert([
                            'idpengadaan'  => $idpengadaan,
                            'idbarang'     => $item['idbarang'],
                            'jumlah'       => $item['jumlah'],
                            'harga_satuan' => $item['harga_satuan'],
                            'sub_total'    => $item['sub_total']
                        ]);
                    }
                });

                return redirect()->route('pengadaan.index')->with('success', 'Pengadaan berhasil dibuat!');
            } catch (\Exception $e) {
                return back()->withInput()->with('error', 'Gagal menyimpan pengadaan: ' . $e->getMessage());
            }
        })->name('pengadaan.store');

        Route::get('pengadaan/{id}/detail', function ($id) {
            $details = DB::table('v_pengadaan')
                ->where('idpengadaan', $id)
                ->get();

            if ($details->isEmpty()) {
                return redirect()->route('pengadaan.index')->with('error', 'Data pengadaan tidak ditemukan.');
            }

            $header = $details->first();
            return view('pengadaan.detail', compact('header', 'details'));
        })->name('pengadaan.detail');

        // TRANSAKSI PENERIMAAN (MULTI-BARANG & SINKRON)
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

            foreach ($pengadaans as $po) {
                $totalPesan = DB::table('detail_pengadaan')
                    ->where('idpengadaan', $po->idpengadaan)
                    ->sum('jumlah');

                $totalTerima = DB::table('detail_penerimaan')
                    ->join('penerimaan', 'detail_penerimaan.idpenerimaan', '=', 'penerimaan.idpenerimaan')
                    ->where('penerimaan.idpengadaan', $po->idpengadaan)
                    ->sum('detail_penerimaan.jumlah_terima');

                $po->is_selesai = ($totalPesan > 0 && $totalTerima >= $totalPesan);
            }

            $users = DB::table('user')->get();

            return view('penerimaan.index', compact('headerPenerimaan', 'pengadaans', 'users'));
        })->name('penerimaan.index');

        Route::post('penerimaan/store', function (Request $request) {
            try {
                if (!$request->idpengadaan) {
                    return back()->with('error', 'Silakan pilih nomor pengadaan terlebih dahulu!');
                }

                $userId = Auth::id() ?? $request->iduser;
                if (!$userId) {
                    $firstUser = DB::table('user')->first();
                    $userId = $firstUser ? $firstUser->iduser : 1;
                }

                $idpenerimaan = DB::table('penerimaan')->insertGetId([
                    'created_at'  => now(),
                    'status'      => 'B',
                    'idpengadaan' => $request->idpengadaan,
                    'iduser'      => $userId
                ]);

                return redirect()->route('penerimaan.detail', $idpenerimaan)
                    ->with('success', 'Header penerimaan berhasil dibuat! Silakan input detail barang.');
            } catch (\Exception $e) {
                return back()->withInput()->with('error', 'Gagal membuat penerimaan: ' . $e->getMessage());
            }
        })->name('penerimaan.store');

        Route::get('penerimaan/{id}/detail', function ($id) {
            $penerimaan = DB::table('penerimaan')
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
                ->select(
                    'barang.idbarang',
                    'barang.nama',
                    'detail_pengadaan.jumlah as jumlah_pesan',
                    'detail_pengadaan.harga_satuan'
                )
                ->get();

            foreach ($barangsPO as $b) {
                $totalSudahTerima = DB::table('detail_penerimaan')
                    ->join('penerimaan', 'detail_penerimaan.idpenerimaan', '=', 'penerimaan.idpenerimaan')
                    ->where('penerimaan.idpengadaan', $penerimaan->idpengadaan)
                    ->where('detail_penerimaan.barang_idbarang', $b->idbarang)
                    ->sum('detail_penerimaan.jumlah_terima');

                $b->sisa_kuota = max(0, $b->jumlah_pesan - $totalSudahTerima);
            }

            return view('penerimaan.detail', compact('penerimaan', 'details', 'barangsPO'));
        })->name('penerimaan.detail');

        Route::post('penerimaan/{id}/detail/store', function (Request $request, $id) {
            try {
                $penerimaan = DB::table('penerimaan')->where('idpenerimaan', $id)->first();
                if (!$penerimaan) {
                    return back()->with('error', 'Transaksi penerimaan tidak valid.');
                }

                $idbarang     = $request->idbarang;
                $jumlahTerima = (int) $request->jumlah_terima;

                $detailPO = DB::table('detail_pengadaan')
                    ->where('idpengadaan', $penerimaan->idpengadaan)
                    ->where('idbarang', $idbarang)
                    ->first();

                if (!$detailPO) {
                    return back()->with('error', 'Barang ini tidak ada dalam daftar PO Pengadaan #' . $penerimaan->idpengadaan . '!');
                }

                $hargaTerima = $request->filled('harga_satuan_terima')
                    ? (int) $request->harga_satuan_terima
                    : (int) $detailPO->harga_satuan;

                $totalSudahDiterima = DB::table('detail_penerimaan')
                    ->join('penerimaan', 'detail_penerimaan.idpenerimaan', '=', 'penerimaan.idpenerimaan')
                    ->where('penerimaan.idpengadaan', $penerimaan->idpengadaan)
                    ->where('detail_penerimaan.barang_idbarang', $idbarang)
                    ->sum('detail_penerimaan.jumlah_terima');

                $sisaBolehDiterima = $detailPO->jumlah - $totalSudahDiterima;

                if ($jumlahTerima > $sisaBolehDiterima) {
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

                return back()->with('success', 'Barang berhasil diterima! Stok, harga barang, dan status pengadaan otomatis diperbarui.');
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal memproses penerimaan: ' . $e->getMessage());
            }
        })->name('penerimaan.detail.store');

        Route::get('penerimaan/{id}/edit', function ($id) {
            $penerimaan = DB::table('penerimaan')->where('idpenerimaan', $id)->first();
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

        Route::put('penerimaan/{id}/update', function (Request $request, $id) {
            try {
                DB::table('penerimaan')
                    ->where('idpenerimaan', $id)
                    ->update([
                        'idpengadaan' => $request->idpengadaan,
                        'iduser'      => $request->iduser,
                        'status'      => $request->status ?? 'B'
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
                $detail = DB::table('detail_penerimaan')->where('iddetail_penerimaan', $iddetail)->first();
                if ($detail) {
                    DB::table('detail_penerimaan')->where('iddetail_penerimaan', $iddetail)->delete();
                    return back()->with('success', 'Item barang berhasil dihapus dari detail penerimaan.');
                }
                return back()->with('error', 'Data detail tidak ditemukan.');
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal menghapus item: ' . $e->getMessage());
            }
        })->name('penerimaan.detail.destroy');
    });
});