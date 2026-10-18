<!DOCTYPE html>
<html>
<head><title>Tambah User</title></head>
<body>
    <h2>Tambah User</h2>
    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <div><label>Username:</label><br><input type="text" name="username" required></div><br>
        <div><label>Password:</label><br><input type="text" name="password" required></div><br>
        <div>
            <label>Role:</label><br>
            <select name="idrole">
                <option value="">-- Pilih Role --</option>
                @foreach($role as $r)
                    <option value="{{ $r->idrole }}">{{ $r->nama_role }}</option>
                @endforeach
            </select>
        </div><br>
        <button type="submit">Simpan</button>
        <a href="{{ route('user.index') }}">Batal</a>
    </form>
</body>
</html>