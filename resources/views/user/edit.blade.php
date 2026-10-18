<!DOCTYPE html>
<html>
<head><title>Edit User</title></head>
<body>
    <h2>Edit User</h2>
    <form action="{{ route('user.update', $user->iduser) }}" method="POST">
        @csrf @method('PUT')
        <div><label>Username:</label><br><input type="text" name="username" value="{{ $user->username }}" required></div><br>
        <div><label>Password:</label><br><input type="text" name="password" value="{{ $user->password }}" required></div><br>
        <div>
            <label>Role:</label><br>
            <select name="idrole">
                <option value="">-- Pilih Role --</option>
                @foreach($role as $r)
                    <option value="{{ $r->idrole }}" {{ $user->idrole == $r->idrole ? 'selected' : '' }}>
                        {{ $r->nama_role }}
                    </option>
                @endforeach
            </select>
        </div><br>
        <button type="submit">Update</button>
        <a href="{{ route('user.index') }}">Batal</a>
    </form>
</body>
</html>