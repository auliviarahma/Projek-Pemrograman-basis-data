<!DOCTYPE html>
<html>
<head><title>Edit Barang</title></head>
<body>
    <h2>Edit Barang</h2>
    <form action="{{ route('barang.update', $barang->idbarang) }}" method="POST">
        @csrf @method('PUT')
        <div>
            <label>Jenis:</label><br>
            <select name="jenis">
                <option value="B" {{ $barang->jenis == 'B' ? 'selected' : '' }}>Bahan Baku (B)</option>
                <option value="P" {{ $barang->jenis == 'P' ? 'selected' : '' }}>Produk Jadi (P)</option>
            </select>
        </div><br>
        <div><label>Nama Barang:</label><br><input type="text" name="nama" value="{{ $barang->nama }}" required></div><br>
        <div>
            <label>Satuan:</label><br>
            <select name="idsatuan">
                <option value="">-- Pilih Satuan --</option>
                @foreach($satuan as $s)
                    <option value="{{ $s->idsatuan }}" {{ $barang->idsatuan == $s->idsatuan ? 'selected' : '' }}>
                        {{ $s->nama_satuan }}
                    </option>
                @endforeach
            </select>
        </div><br>
        <div>
            <label>Status:</label><br>
            <select name="status">
                <option value="1" {{ $barang->status == 1 ? 'selected' : '' }}>Aktif (1)</option>
                <option value="0" {{ $barang->status == 0 ? 'selected' : '' }}>Non-Aktif (0)</option>
            </select>
        </div><br>
        <div><label>Harga (Rp):</label><br><input type="number" name="harga" value="{{ $barang->harga }}" required></div><br>
        <button type="submit">Update</button>
        <a href="{{ route('barang.index') }}">Batal</a>
    </form>
</body>
</html>