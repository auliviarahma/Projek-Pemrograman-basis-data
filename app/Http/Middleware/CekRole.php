<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();
        $namaRole = DB::table('role')->where('idrole', $user->idrole)->value('nama_role');

        $roleUser = strtolower(trim($namaRole ?? ''));
        $allowedRoles = array_map(fn($r) => strtolower(trim($r)), $roles);

        if (!in_array($roleUser, $allowedRoles)) {
            return redirect()->route('dashboard')
                ->with('error', 'Akses ditolak! Halaman tersebut khusus untuk Super Admin.');
        }

        return $next($request);
    }
}