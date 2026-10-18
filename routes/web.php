<?php

use Illuminate\Support\Facades\Route;
use App\Models\Satuan;
use App\Models\Barang;
use App\Models\Vendor;
use App\Models\Role;
use App\Models\User;
use App\Models\MarginPenjualan; // <-- Tambahkan ini

use App\Http\Controllers\SatuanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarginPenjualanController; // <-- Tambahkan ini

Route::get('/', function () {
    $totalSatuan = Satuan::count();
    $totalBarang = Barang::count();
    $totalVendor = Vendor::count();
    $totalRole   = Role::count();
    $totalUser   = User::count();
    $totalMargin = MarginPenjualan::count(); // <-- Hitung total margin

    return view('dashboard', compact(
        'totalSatuan', 
        'totalBarang', 
        'totalVendor', 
        'totalRole', 
        'totalUser',
        'totalMargin' // <-- Kirim ke view
    ));
})->name('dashboard');

// CRUD Resources
Route::resource('satuan', SatuanController::class);
Route::resource('barang', BarangController::class);
Route::resource('vendor', VendorController::class);
Route::resource('role', RoleController::class);
Route::resource('user', UserController::class);
Route::resource('margin-penjualan', MarginPenjualanController::class); 