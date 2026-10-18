<!DOCTYPE html>
<html>
<head><title>Tambah Role</title></head>
<body>
    <h2>Tambah Role</h2>
    <form action="{{ route('role.store') }}" method="POST">
        @csrf
        <div><label>Nama Role:</label><br><input type="text" name="nama_role" required></div><br>
        <button type="submit">Simpan</button>
        <a href="{{ route('role.index') }}">Batal</a>
    </form>
</body>
</html>