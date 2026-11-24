<?php

namespace App\Http\Controllers;

use App\Models\MarginPenjualan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarginPenjualanController extends Controller
{
    // READ: Murni membaca dari SQL View view_margin_penjualan (sesuai aturan dosen)
    public function index()
    {
        $margin = DB::table('view_margin_penjualan')
            ->orderBy('idmargin_penjualan', 'desc')
            ->get();

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
            'status' => 'required|in:0,1',
            'iduser' => 'nullable|exists:user,iduser',
        ]);

        // Fallback user jika tidak memilih user
        $userId = $request->iduser;
        if (!$userId) {
            $firstUser = User::first();
            $userId = $firstUser ? $firstUser->iduser : 1;
        }

        $marginBaru = MarginPenjualan::create([
            'persen'     => $request->persen,
            'status'     => 0, // Set 0 dulu agar rotasi ditangani SP
            'iduser'     => $userId,
            'created_at' => now(),
        ]);

        // otomatis mati dan nyala
        if ((int) $request->status === 1) {
            DB::statement("CALL sp_set_margin_aktif(?)", [$marginBaru->idmargin_penjualan]);
        }

        return redirect()->route('margin-penjualan.index')
            ->with('success', 'Margin penjualan berhasil ditambahkan');
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
            'status' => 'required|in:0,1',
            'iduser' => 'nullable|exists:user,iduser',
        ]);

        $margin = MarginPenjualan::findOrFail($id);
        $userId = $request->iduser ?? $margin->iduser;

        $margin->update([
            'persen' => $request->persen,
            'status' => $request->status,
            'iduser' => $userId,
        ]);

        // Jika status diubah menjadi Aktif (1), panggil SP untuk menonaktifkan margin lainnya
        if ((int) $request->status === 1) {
            DB::statement("CALL sp_set_margin_aktif(?)", [$id]);
        }

        return redirect()->route('margin-penjualan.index')
            ->with('success', 'Margin penjualan berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $margin = MarginPenjualan::findOrFail($id);
        $margin->delete();
        return redirect()->route('margin-penjualan.index')
            ->with('success', 'Margin penjualan berhasil dihapus');
    }

    // STORED PROCEDURE: Menjalankan sp_set_margin_aktif untuk merotasi status margin
    public function aktifkan(string $id)
    {
        try {
            DB::statement("CALL sp_set_margin_aktif(?)", [$id]);

            return redirect()->route('margin-penjualan.index')
                ->with('success', 'Margin aktif berhasil diperbarui melalui Stored Procedure!');
        } catch (\Exception $e) {
            return redirect()->route('margin-penjualan.index')
                ->with('error', 'Gagal memicu Stored Procedure sp_set_margin_aktif: ' . $e->getMessage());
        }
    }
}