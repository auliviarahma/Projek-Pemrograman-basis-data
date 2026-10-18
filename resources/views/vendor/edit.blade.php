<!DOCTYPE html>
<html>
<head><title>Edit Vendor</title></head>
<body>
    <h2>Edit Vendor</h2>
    <form action="{{ route('vendor.update', $vendor->idvendor) }}" method="POST">
        @csrf @method('PUT')
        <div><label>Nama Vendor:</label><br><input type="text" name="nama_vendor" value="{{ $vendor->nama_vendor }}" required></div><br>
        <div>
            <label>Badan Hukum:</label><br>
            <select name="badan_hukum">
                <option value="1" {{ $vendor->badan_hukum == '1' ? 'selected' : '' }}>Ada (1)</option>
                <option value="0" {{ $vendor->badan_hukum == '0' ? 'selected' : '' }}>Tidak Ada (0)</option>
            </select>
        </div><br>
        <div>
            <label>Status:</label><br>
            <select name="status">
                <option value="1" {{ $vendor->status == '1' ? 'selected' : '' }}>Aktif (1)</option>
                <option value="0" {{ $vendor->status == '0' ? 'selected' : '' }}>Non-Aktif (0)</option>
            </select>
        </div><br>
        <button type="submit">Update</button>
        <a href="{{ route('vendor.index') }}">Batal</a>
    </form>
</body>
</html>