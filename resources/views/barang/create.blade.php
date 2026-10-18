<!DOCTYPE html>
<html>
<head><title>Tambah Barang</title></head>
<body>
    <h2>Tambah Barang</h2>
    <form action="{{ route('barang.store') }}" method="POST">
        @csrf
        <div>
            <label>Jenis:</label><br>
            <select name="jenis">
                <option value="B">Bahan Baku (B)</option>
                <option value="P">Produk Jadi (P)</option>
            </select>
        </div><br>
        <div><label>Nama Barang:</label><br><input type="text" name="nama" required></div><br>
        <div>
            <label>Satuan:</label><br>
            <select name="idsatuan">
                <option value="">-- Pilih Satuan --</option>
                @foreach($satuan as $s)
                    <option value="{{ $s->idsatuan }}">{{ $s->nama_satuan }}</option>
                @endforeach
            </select>
        </div><br>
        <div>
            <label>Status:</label><br>
            <select name="status">
                <option value="1">Aktif (1)</option>
                <option value="0">Non-Aktif (0)</option>
            </select>
        </div><br>
        <div><label>Harga (Rp):</label><br><input type="number" name="harga" required></div><br>
        <button type="submit">Simpan</button>
        <a href="{{ route('barang.index') }}">Batal</a>
    </form>
</body>
</html>