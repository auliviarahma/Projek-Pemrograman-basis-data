@extends('layouts.simba')

@section('title', 'Kartu Stok - SIMBA')

@section('content')
<style>
    .badge-masuk {
        background-color: #dcfce7;
        color: #15803d;
        font-weight: 700;
    }

    .badge-keluar {
        background-color: #fee2e2;
        color: #b91c1c;
        font-weight: 700;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a;">Buku Besar Kartu Stok</h3>
        <p class="text-secondary small mb-0">Catatan otomatisasi mutasi stok dari SQL View (<code>view_kartu_stok</code>) &amp; Trigger MySQL</p>
    </div>
    <a href="/" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
    </a>
</div>

<!-- TABEL MUTASI KARTU STOK -->
<div class="card-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu Mutasi</th>
                    <th>Nama Barang</th>
                    <th class="text-center">Jenis Transaksi</th>
                    <th class="text-end">Masuk (+)</th>
                    <th class="text-end">Keluar (-)</th>
                    <th class="text-end">Sisa Stok Akhir</th>
                    <th class="text-center">ID Transaksi Asal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kartuStok as $index => $row)
                    <tr>
                        <td class="text-muted small">{{ $index + 1 }}</td>
                        <td>{{ $row->created_at }}</td>
                        <td class="fw-bold text-dark">{{ $row->nama_barang }}</td>
                        <td class="text-center">
                            @if ($row->jenis_transaksi == 'M')
                                <span class="badge badge-masuk px-2 py-1">M - Penerimaan</span>
                            @elseif ($row->jenis_transaksi == 'K')
                                <span class="badge badge-keluar px-2 py-1">K - Penjualan</span>
                            @else
                                <span class="badge bg-secondary px-2 py-1">{{ $row->jenis_transaksi }}</span>
                            @endif
                        </td>
                        <td class="text-end fw-semibold text-success">
                            {{ $row->masuk > 0 ? '+' . number_format($row->masuk) : '-' }}
                        </td>
                        <td class="text-end fw-semibold text-danger">
                            {{ $row->keluar > 0 ? '-' . number_format($row->keluar) : '-' }}
                        </td>
                        <td class="text-end fw-bold text-primary">
                            {{ number_format($row->stock) }}
                        </td>
                        <td class="text-center text-muted">
                            @if (!empty($row->idtransaksi))
                                #{{ $row->idtransaksi }}
                            @else
                                <span class="small fst-italic">- (Data Awal)</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            Belum ada riwayat transaksi yang memicu trigger kartu stok.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection