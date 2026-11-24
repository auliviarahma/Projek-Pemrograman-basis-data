@extends('layouts.simba')

@section('title', 'Edit User - SIMBA')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a;">Edit Data User</h3>
        <p class="text-secondary small mb-0">Perbarui akun pengguna #{{ $user->iduser }}</p>
    </div>
    <a href="{{ route('user.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('user.update', $user->iduser) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">USERNAME</label>
                <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">PASSWORD</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                <div class="form-text text-muted small">Biarkan kosong apabila password lama tetap digunakan.</div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold small text-secondary">ROLE / HAK AKSES</label>
                <select name="idrole" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    @foreach($role as $r)
                        <option value="{{ $r->idrole }}" {{ $user->idrole == $r->idrole ? 'selected' : '' }}>
                            {{ $r->nama_role }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary fw-bold px-4" style="background-color: #0284c7; border-color: #0284c7;">
                    <i class="fa-solid fa-save me-1"></i> Update User
                </button>
                <a href="{{ route('user.index') }}" class="btn btn-outline-secondary fw-semibold px-3">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection