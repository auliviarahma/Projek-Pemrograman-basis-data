@extends('layouts.simba')

@section('title', 'Master Vendor - SIMBA')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a;">Master Vendor</h3>
        <p class="text-secondary small mb-0">Data diambil dari SQL View <code>view_vendor</code></p>
    </div>
    <a href="{{ route('vendor.create') }}" class="btn btn-primary fw-bold px-3" style="background-color: #0284c7; border: none;">
        <i class="fa-solid fa-plus me-1"></i> Tambah Vendor
    </a>
</div>

@php
    $listVendor = $vendors ?? $vendor ?? $data ?? [];
@endphp

<div class="card-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Vendor</th>
                    <th>Badan Hukum</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listVendor as $v)
                    <tr>
                        <td class="fw-bold text-muted">#{{ $v->idvendor }}</td>
                        <td class="fw-bold text-dark">{{ $v->nama_vendor }}</td>
                        <td>
                            @if ($v->badan_hukum == 'P')
                                <span class="badge bg-primary-subtle text-primary px-2 py-1">PT (Perseroan Terbatas)</span>
                            @elseif ($v->badan_hukum == 'C')
                                <span class="badge bg-secondary-subtle text-secondary px-2 py-1">CV (Commanditaire Vennootschap)</span>
                            @else
                                <span class="badge bg-light text-dark border px-2 py-1">{{ $v->badan_hukum }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($v->status == '1' || $v->status == 1)
                                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill fw-bold">Aktif</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger px-3 py-1 rounded-pill fw-bold">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('vendor.edit', $v->idvendor) }}" class="btn btn-sm btn-outline-primary fw-semibold">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form action="{{ route('vendor.destroy', $v->idvendor) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus vendor ini?')">
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
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data vendor.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection