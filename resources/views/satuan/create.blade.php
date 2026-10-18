<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Satuan</title>
</head>
<body>
    <h2>Tambah Data Satuan</h2>
    <form action="{{ route('satuan.store') }}" method="POST">
        @csrf
        <div>
            <label>Nama Satuan:</label><br>
            <input type="text" name="nama_satuan" required placeholder="Contoh: Pcs, Dus, Kg">
        </div>
        <br>
        <div>
            <label>Status:</label><br>
            <select name="status">
                <option value="1">Aktif (1)</option>
                <option value="0">Non-Aktif (0)</option>
            </select>
        </div>
        <br>
        <button type="submit">Simpan</button>
        <a href="{{ route('satuan.index') }}">Batal</a>
    </form>
</body>
</html>