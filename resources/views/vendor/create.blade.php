<!DOCTYPE html>
<html>
<head><title>Tambah Vendor</title></head>
<body>
    <h2>Tambah Vendor</h2>
    <form action="{{ route('vendor.store') }}" method="POST">
        @csrf
        <div><label>Nama Vendor:</label><br><input type="text" name="nama_vendor" required></div><br>
        <div>
            <label>Badan Hukum:</label><br>
            <select name="badan_hukum">
                <option value="1">Ada (1)</option>
                <option value="0">Tidak Ada (0)</option>
            </select>
        </div><br>
        <div>
            <label>Status:</label><br>
            <select name="status">
                <option value="1">Aktif (1)</option>
                <option value="0">Non-Aktif (0)</option>
            </select>
        </div><br>
        <button type="submit">Simpan</button>
        <a href="{{ route('vendor.index') }}">Batal</a>
    </form>
</body>
</html>