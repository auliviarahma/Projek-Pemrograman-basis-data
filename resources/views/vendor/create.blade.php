@extends('layouts.simba')

@section('title', 'Tambah Vendor - SIMBA')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a;">Tambah Vendor Baru</h3>
        <p class="text-secondary small mb-0">Daftarkan supplier / vendor baru ke sistem</p>
    </div>
    <a href="{{ route('vendor.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('vendor.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">NAMA VENDOR</label>
                <input type="text" name="nama_vendor" class="form-control" placeholder="Contoh: PT Sumber Makmur" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">BADAN HUKUM</label>
                <select name="badan_hukum" class="form-select" required>
                    <option value="">-- Pilih Badan Hukum --</option>
                    <option value="P">PT (Perseroan Terbatas)</option>
                    <option value="C">CV (Commanditaire Vennootschap)</option>
                    <option value="U">UD (Usaha Dagang) / Perorangan</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold small text-secondary">STATUS</label>
                <select name="status" class="form-select" required>
                    <option value="1" selected>Aktif (1)</option>
                    <option value="0">Non-Aktif (0)</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary fw-bold px-4" style="background-color: #0284c7; border-color: #0284c7;">
                    <i class="fa-solid fa-save me-1"></i> Simpan Vendor
                </button>
                <a href="{{ route('vendor.index') }}" class="btn btn-outline-secondary fw-semibold px-3">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection