<!DOCTYPE html>
<html>
<head><title>Edit Role</title></head>
<body>
    <h2>Edit Role</h2>
    <form action="{{ route('role.update', $role->idrole) }}" method="POST">
        @csrf @method('PUT')
        <div><label>Nama Role:</label><br><input type="text" name="nama_role" value="{{ $role->nama_role }}" required></div><br>
        <button type="submit">Update</button>
        <a href="{{ route('role.index') }}">Batal</a>
    </form>
</body>
</html>