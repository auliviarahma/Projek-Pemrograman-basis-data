@extends('layouts.simba')

@section('title', 'Master User - SIMBA')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a;">Master User</h3>
        <p class="text-secondary small mb-0">Data diambil dari SQL View <code>view_user</code></p>
    </div>
    <a href="{{ route('user.create') }}" class="btn btn-primary fw-bold px-3" style="background-color: #0284c7; border: none;">
        <i class="fa-solid fa-plus me-1"></i> Tambah User
    </a>
</div>

@php
    $listUser = $users ?? $user ?? $data ?? [];
@endphp

<div class="card-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listUser as $u)
                    <tr>
                        <td class="fw-bold text-muted">#{{ $u->iduser }}</td>
                        <td class="fw-bold text-dark">{{ $u->username }}</td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary px-2 py-1 fw-semibold">{{ $u->nama_role ?? '-' }}</span>
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('user.edit', $u->iduser) }}" class="btn btn-sm btn-outline-primary fw-semibold">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form action="{{ route('user.destroy', $u->iduser) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger fw-semibold">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Belum ada data user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection