<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CekRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        $namaRole = DB::table('role')->where('idrole', $user->idrole)->value('nama_role');

        // Normalisasi huruf kecil agar pengecekan fleksibel (misal: "Super Admin" atau "super_admin")
        $roleUser = strtolower(trim($namaRole ?? ''));
        $allowedRoles = array_map(fn($r) => strtolower(trim($r)), $roles);

        if (!in_array($roleUser, $allowedRoles)) {
            return redirect()->route('dashboard')
                ->with('error', 'Akses ditolak! Halaman tersebut hanya untuk ' . implode(' / ', $roles) . '.');
        }

        return $next($request);
    }
}