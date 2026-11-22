@extends('layouts.simba')

@section('title', 'Master Satuan - SIMBA')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a;">Master Satuan</h3>
        <p class="text-secondary small mb-0">Data diambil dari SQL View <code>view_satuan</code></p>
    </div>
    <a href="{{ route('satuan.create') }}" class="btn btn-primary fw-bold px-3" style="background-color: #0284c7; border: none;">
        <i class="fa-solid fa-plus me-1"></i> Tambah Satuan
    </a>
</div>

@php
    $listSatuan = $satuans ?? $satuan ?? $data ?? [];
@endphp

<div class="card-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Satuan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listSatuan as $s)
                    <tr>
                        <td class="fw-bold text-muted">#{{ $s->idsatuan }}</td>
                        <td class="fw-bold text-dark">{{ $s->nama_satuan }}</td>
                        <td class="text-center">
                            @if ($s->status == 1)
                                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill fw-bold">Aktif</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger px-3 py-1 rounded-pill fw-bold">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('satuan.edit', $s->idsatuan) }}" class="btn btn-sm btn-outline-primary fw-semibold">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form action="{{ route('satuan.destroy', $s->idsatuan) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus satuan ini?')">
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
                        <td colspan="4" class="text-center py-4 text-muted">Belum ada data satuan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection