<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Ditambahkan untuk query Database View

class UserController extends Controller
{
    // READ 1: Menampilkan daftar data user dari Database View (view_user)
    public function index()
    {
        $user = DB::table('view_user')->get();
        return view('user.index', compact('user'));
    }

    // READ 2: Mengambil opsi daftar role dari Database View (view_role)
    public function create()
    {
        $role = DB::table('view_role')->get();
        return view('user.create', compact('role'));
    }

    // CREATE: Menyimpan data baru ke tabel fisik user via Model
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|max:45|unique:user,username',
            'password' => 'required|max:100',
            'idrole'   => 'nullable|exists:role,idrole',
        ]);

        User::create($request->all());
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    // READ 3: Mengambil detail data user dan opsi role dari Database View
    public function edit(string $id)
    {
        $user = DB::table('view_user')->where('iduser', $id)->first();

        if (!$user) {
            abort(404, 'Data user tidak ditemukan');
        }

        $role = DB::table('view_role')->get();
        return view('user.edit', compact('user', 'role'));
    }

    // UPDATE: Memperbarui data pada tabel fisik user via Model
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|max:45|unique:user,username,' . $id . ',iduser',
            'password' => 'required|max:100',
            'idrole'   => 'nullable|exists:role,idrole',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
    }

    // DELETE: Menghapus data dari tabel fisik user via Model
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}