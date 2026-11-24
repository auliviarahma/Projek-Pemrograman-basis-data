@extends('layouts.simba')

@section('title', 'Tambah Role - SIMBA')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a;">Tambah Role Baru</h3>
        <p class="text-secondary small mb-0">Daftarkan hak akses / role pengguna baru ke sistem</p>
    </div>
    <a href="{{ route('role.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('role.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="form-label fw-bold small text-secondary">NAMA ROLE</label>
                <input type="text" name="nama_role" class="form-control" placeholder="Contoh: Super Admin / Kasir / Gudang" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary fw-bold px-4" style="background-color: #0284c7; border-color: #0284c7;">
                    <i class="fa-solid fa-save me-1"></i> Simpan Role
                </button>
                <a href="{{ route('role.index') }}" class="btn btn-outline-secondary fw-semibold px-3">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection