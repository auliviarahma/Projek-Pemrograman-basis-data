<?php

namespace App\Http\Controllers;

use App\Models\MarginPenjualan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarginPenjualanController extends Controller
{
    // READ: Memanggil SQL View view_margin_penjualan (dengan fallback ke tabel jika view belum ada)
    public function index()
    {
        try {
            $margin = DB::table('view_margin_penjualan')
                ->orderBy('idmargin_penjualan', 'desc')
                ->get();
        } catch (\Exception $e) {
            // Fallback membaca langsung dari tabel margin_penjualan jika view belum terpasang
            $margin = DB::table('margin_penjualan')
                ->leftJoin('user', 'margin_penjualan.iduser', '=', 'user.iduser')
                ->select('margin_penjualan.*', 'user.username')
                ->orderBy('margin_penjualan.idmargin_penjualan', 'desc')
                ->get();
        }

        return view('margin_penjualan.index', compact('margin'));
    }

    public function create()
    {
        $user = User::all();
        return view('margin_penjualan.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'persen' => 'required|numeric|min:0',
            'status' => 'required|numeric',
            'iduser' => 'nullable|exists:user,iduser',
        ]);

        // Fallback user jika tidak memilih user
        $userId = $request->iduser;
        if (!$userId) {
            $firstUser = User::first();
            $userId = $firstUser ? $firstUser->iduser : 1;
        }

        MarginPenjualan::create([
            'persen'     => $request->persen,
            'status'     => $request->status,
            'iduser'     => $userId,
            'created_at' => now(),
        ]);

        return redirect()->route('margin-penjualan.index')->with('success', 'Margin penjualan berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $margin = MarginPenjualan::findOrFail($id);
        $user = User::all();
        return view('margin_penjualan.edit', compact('margin', 'user'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'persen' => 'required|numeric|min:0',
            'status' => 'required|numeric',
            'iduser' => 'nullable|exists:user,iduser',
        ]);

        $margin = MarginPenjualan::findOrFail($id);
        
        $userId = $request->iduser ?? $margin->iduser;

        $margin->update([
            'persen' => $request->persen,
            'status' => $request->status,
            'iduser' => $userId,
        ]);

        return redirect()->route('margin-penjualan.index')->with('success', 'Margin penjualan berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $margin = MarginPenjualan::findOrFail($id);
        $margin->delete();
        return redirect()->route('margin-penjualan.index')->with('success', 'Margin penjualan berhasil dihapus');
    }

    // STORED PROCEDURE: Menjalankan SP untuk mengaktifkan satu margin & menonaktifkan yang lain
    public function aktifkan(string $id)
    {
        try {
            // Eksekusi Stored Procedure
            DB::statement("CALL sp_set_margin_aktif(?)", [$id]);

            return redirect()->route('margin-penjualan.index')
                ->with('success', 'Margin aktif berhasil diperbarui melalui Stored Procedure!');
        } catch (\Exception $e) {
            // Alternatif jika nama SP di DB adalah sp_aktifkan_margin
            try {
                DB::statement("CALL sp_aktifkan_margin(?)", [$id]);
                return redirect()->route('margin-penjualan.index')
                    ->with('success', 'Margin aktif berhasil diperbarui!');
            } catch (\Exception $ex) {
                return redirect()->route('margin-penjualan.index')
                    ->with('error', 'Gagal memicu Stored Procedure: ' . $ex->getMessage());
            }
        }
    }
}