@extends('layouts.simba')

@section('title', 'Edit Barang - SIMBA')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a;">Edit Data Barang</h3>
        <p class="text-secondary small mb-0">Perbarui informasi master barang #{{ $barang->idbarang }}</p>
    </div>
    <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('barang.update', $barang->idbarang) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">JENIS BARANG</label>
                <select name="jenis" class="form-select" required>
                    <option value="B" {{ $barang->jenis == 'B' ? 'selected' : '' }}>Bahan Baku (B)</option>
                    <option value="P" {{ $barang->jenis == 'P' ? 'selected' : '' }}>Produk Jadi (P)</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">NAMA BARANG</label>
                <input type="text" name="nama" class="form-control" value="{{ $barang->nama_barang ?? $barang->nama }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">SATUAN</label>
                <select name="idsatuan" class="form-select" required>
                    <option value="">-- Pilih Satuan --</option>
                    @foreach($satuan as $s)
                        <option value="{{ $s->idsatuan }}" {{ $barang->idsatuan == $s->idsatuan ? 'selected' : '' }}>
                            {{ $s->nama_satuan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">STATUS</label>
                <select name="status" class="form-select" required>
                    <option value="1" {{ $barang->status == 1 ? 'selected' : '' }}>Aktif (1)</option>
                    <option value="0" {{ $barang->status == 0 ? 'selected' : '' }}>Non-Aktif (0)</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold small text-secondary">HARGA DASAR (RP)</label>
                <input type="number" name="harga" class="form-control" value="{{ $barang->harga }}" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary fw-bold px-4" style="background-color: #0284c7; border-color: #0284c7;">
                    <i class="fa-solid fa-save me-1"></i> Update Barang
                </button>
                <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary fw-semibold px-3">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection