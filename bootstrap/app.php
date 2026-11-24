<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'superadmin' => function ($request, $next) {
                $namaRole = DB::table('role')->where('idrole', Auth::user()->idrole)->value('nama_role');
                if (strtolower(trim($namaRole ?? '')) !== 'super admin') {
                    return redirect()->route('dashboard')->with('error', 'Akses ditolak! Halaman tersebut hanya untuk Super Admin.');
                }
                return $next($request);
            },
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();