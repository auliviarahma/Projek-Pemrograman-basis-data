<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Satuan</title>
</head>
<body>
    <h2>Edit Data Satuan</h2>
    <form action="{{ route('satuan.update', $satuan->idsatuan) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Nama Satuan:</label><br>
            <input type="text" name="nama_satuan" value="{{ $satuan->nama_satuan }}" required>
        </div>
        <br>
        <div>
            <label>Status:</label><br>
            <select name="status">
                <option value="1" {{ $satuan->status == 1 ? 'selected' : '' }}>Aktif (1)</option>
                <option value="0" {{ $satuan->status == 0 ? 'selected' : '' }}>Non-Aktif (0)</option>
            </select>
        </div>
        <br>
        <button type="submit">Update Data</button>
        <a href="{{ route('satuan.index') }}">Batal</a>
    </form>
</body>
</html>