<?php

use Illuminate\Support\Facades\Route;
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

// CRUD Resources
Route::resource('satuan', SatuanController::class);
Route::resource('barang', BarangController::class);
Route::resource('vendor', VendorController::class);
Route::resource('role', RoleController::class);
Route::resource('user', UserController::class);

// Rute khusus untuk aktivasi margin via Stored Procedure
Route::post('margin-penjualan/{id}/aktifkan', [MarginPenjualanController::class, 'aktifkan'])
    ->name('margin-penjualan.aktifkan');

Route::resource('margin-penjualan', MarginPenjualanController::class);