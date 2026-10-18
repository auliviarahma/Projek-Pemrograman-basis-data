<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Ditambahkan untuk query Database View

class RoleController extends Controller
{
    // READ 1: Menampilkan daftar role langsung dari Database View (view_role)
    public function index()
    {
        $role = DB::table('view_role')->get();
        return view('role.index', compact('role'));
    }

    public function create()
    {
        return view('role.create');
    }

    // CREATE: Menyimpan data baru tetap ke tabel fisik role via Model
    public function store(Request $request)
    {
        $request->validate([
            'nama_role' => 'required|max:100',
        ]);

        Role::create($request->all());
        return redirect()->route('role.index')->with('success', 'Role berhasil ditambahkan');
    }

    // READ 2: Mengambil detail data role dari Database View (view_role)
    public function edit(string $id)
    {
        $role = DB::table('view_role')->where('idrole', $id)->first();

        if (!$role) {
            abort(404, 'Data role tidak ditemukan');
        }

        return view('role.edit', compact('role'));
    }

    // UPDATE: Memperbarui data pada tabel fisik role via Model
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_role' => 'required|max:100',
        ]);

        $role = Role::findOrFail($id);
        $role->update($request->all());
        return redirect()->route('role.index')->with('success', 'Role berhasil diperbarui');
    }

    // DELETE: Menghapus data dari tabel fisik role via Model
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('role.index')->with('success', 'Role berhasil dihapus');
    }
}