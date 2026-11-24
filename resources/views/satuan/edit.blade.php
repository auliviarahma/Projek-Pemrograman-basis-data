@extends('layouts.simba')

@section('title', 'Edit Satuan - SIMBA')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a;">Edit Data Satuan</h3>
        <p class="text-secondary small mb-0">Perbarui informasi satuan #{{ $satuan->idsatuan }}</p>
    </div>
    <a href="{{ route('satuan.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('satuan.update', $satuan->idsatuan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">NAMA SATUAN</label>
                <input type="text" name="nama_satuan" class="form-control" value="{{ $satuan->nama_satuan }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold small text-secondary">STATUS</label>
                <select name="status" class="form-select" required>
                    <option value="1" {{ $satuan->status == 1 ? 'selected' : '' }}>Aktif (1)</option>
                    <option value="0" {{ $satuan->status == 0 ? 'selected' : '' }}>Non-Aktif (0)</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary fw-bold px-4" style="background-color: #0284c7; border-color: #0284c7;">
                    <i class="fa-solid fa-save me-1"></i> Update Satuan
                </button>
                <a href="{{ route('satuan.index') }}" class="btn btn-outline-secondary fw-semibold px-3">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection