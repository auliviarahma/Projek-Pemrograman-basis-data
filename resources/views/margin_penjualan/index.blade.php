@extends('layouts.simba')

@section('title', 'Master Margin Penjualan - SIMBA')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a;">Master Margin Penjualan</h3>
        <p class="text-secondary small mb-0">Data diambil dari SQL View <code>view_margin_penjualan</code> &amp; aktivasi via SP <code>sp_set_margin_aktif</code></p>
    </div>
    <a href="{{ route('margin-penjualan.create') }}" class="btn btn-primary fw-bold px-3" style="background-color: #0284c7; border: none;">
        <i class="fa-solid fa-plus me-1"></i> Tambah Margin
    </a>
</div>

@php
    $listMargin = $margins ?? $marginPenjualan ?? $marginPenjualans ?? $margin ?? $data ?? [];
@endphp

<div class="card-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Persentase Margin</th>
                    <th class="text-center">Status</th>
                    <th>Diinput Oleh</th>
                    <th>Tanggal Dibuat</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listMargin as $m)
                    <tr>
                        <td class="fw-bold text-muted">#{{ $m->idmargin_penjualan }}</td>
                        <td>
                            <span class="badge bg-success-subtle text-success px-2 py-1 fw-bold">{{ $m->persen }}%</span>
                        </td>
                        <td class="text-center">
                            @if ($m->status == 1)
                                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill fw-bold">
                                    <i class="fa-solid fa-check me-1"></i> Aktif
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger px-3 py-1 rounded-pill fw-bold">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $m->username ?? '-' }}</td>
                        <td class="text-muted">{{ $m->created_at }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1 flex-wrap justify-content-center">
                                @if ($m->status != 1)
                                    <form action="{{ route('margin-penjualan.aktifkan', $m->idmargin_penjualan) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success fw-semibold">
                                            <i class="fa-solid fa-power-off me-1"></i> Aktifkan
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('margin-penjualan.edit', $m->idmargin_penjualan) }}" class="btn btn-sm btn-outline-primary fw-semibold">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form action="{{ route('margin-penjualan.destroy', $m->idmargin_penjualan) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus margin ini?')">
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
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data margin penjualan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection