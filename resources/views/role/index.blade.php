@extends('layouts.simba')

@section('title', 'Master Role - SIMBA')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a;">Master Role</h3>
        <p class="text-secondary small mb-0">Data diambil dari SQL View <code>view_role</code></p>
    </div>
    <a href="{{ route('role.create') }}" class="btn btn-primary fw-bold px-3" style="background-color: #0284c7; border: none;">
        <i class="fa-solid fa-plus me-1"></i> Tambah Role
    </a>
</div>

@php
    $listRole = $roles ?? $role ?? $data ?? [];
@endphp

<div class="card-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Role</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listRole as $r)
                    <tr>
                        <td class="fw-bold text-muted">#{{ $r->idrole }}</td>
                        <td class="fw-bold text-dark">{{ $r->nama_role }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('role.edit', $r->idrole) }}" class="btn btn-sm btn-outline-primary fw-semibold">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form action="{{ route('role.destroy', $r->idrole) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus role ini?')">
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
                        <td colspan="3" class="text-center py-4 text-muted">Belum ada data role.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection