<?php

namespace App\Http\Controllers;

use App\Models\MarginPenjualan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarginPenjualanController extends Controller
{
    // READ: Memanggil SQL View view_margin_penjualan
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
            'status' => 'required|numeric',
            'iduser' => 'nullable|exists:user,iduser',
        ]);

        MarginPenjualan::create([
            'persen'     => $request->persen,
            'status'     => $request->status,
            'iduser'     => $request->iduser,
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
        $margin->update([
            'persen' => $request->persen,
            'status' => $request->status,
            'iduser' => $request->iduser,
        ]);

        return redirect()->route('margin-penjualan.index')->with('success', 'Margin penjualan berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $margin = MarginPenjualan::findOrFail($id);
        $margin->delete();
        return redirect()->route('margin-penjualan.index')->with('success', 'Margin penjualan berhasil dihapus');
    }
}