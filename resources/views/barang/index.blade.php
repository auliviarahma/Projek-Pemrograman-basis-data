@extends('layouts.simba')

@section('title', 'Master Barang - SIMBA')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a;">Master Barang</h3>
        <p class="text-secondary small mb-0">Data diambil dari SQL View <code>view_barang</code></p>
    </div>
    <a href="{{ route('barang.create') }}" class="btn btn-primary fw-bold px-3" style="background-color: #0284c7; border: none;">
        <i class="fa-solid fa-plus me-1"></i> Tambah Barang
    </a>
</div>

@php
    $listBarang = $barangs ?? $barang ?? $data ?? [];
@endphp

<div class="card-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jenis</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th class="text-end">Harga Dasar</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listBarang as $b)
                    <tr>
                        <td class="fw-bold text-muted">#{{ $b->idbarang }}</td>
                        <td>
                            <span class="badge bg-info-subtle text-info-emphasis px-2 py-1">{{ $b->jenis }}</span>
                        </td>
                        <td class="fw-bold text-dark">{{ $b->nama_barang ?? $b->nama }}</td>
                        <td>{{ $b->nama_satuan ?? '-' }}</td>
                        <td class="text-end fw-semibold">Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if ($b->status == 1)
                                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill fw-bold">Aktif</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger px-3 py-1 rounded-pill fw-bold">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('barang.edit', $b->idbarang) }}" class="btn btn-sm btn-outline-primary fw-semibold">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form action="{{ route('barang.destroy', $b->idbarang) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus barang ini?')">
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
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data barang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection