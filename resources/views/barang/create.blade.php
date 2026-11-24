@extends('layouts.simba')

@section('title', 'Tambah Barang - SIMBA')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a;">Tambah Barang Baru</h3>
        <p class="text-secondary small mb-0">Daftarkan item barang baru ke sistem</p>
    </div>
    <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('barang.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">JENIS BARANG</label>
                <select name="jenis" class="form-select" required>
                    <option value="B">Bahan Baku (B)</option>
                    <option value="P" selected>Produk Jadi (P)</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">NAMA BARANG</label>
                <input type="text" name="nama" class="form-control" placeholder="Contoh: Sabun Mandi / Minyak Goreng" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">SATUAN</label>
                <select name="idsatuan" class="form-select" required>
                    <option value="">-- Pilih Satuan --</option>
                    @foreach($satuan as $s)
                        <option value="{{ $s->idsatuan }}">{{ $s->nama_satuan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">STATUS</label>
                <select name="status" class="form-select" required>
                    <option value="1" selected>Aktif (1)</option>
                    <option value="0">Non-Aktif (0)</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold small text-secondary">HARGA DASAR (RP)</label>
                <input type="number" name="harga" class="form-control" placeholder="Contoh: 15000" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary fw-bold px-4" style="background-color: #0284c7; border-color: #0284c7;">
                    <i class="fa-solid fa-save me-1"></i> Simpan Barang
                </button>
                <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary fw-semibold px-3">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection