

<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">Riwayat Transaksi Penjualan</h5>
                <small class="text-muted">Otomatis memotong kartu stok via Trigger MySQL</small>
            </div>
            <a href="{{ route('penjualan.create') }}" class="btn btn-primary btn-sm rounded-3 px-3">
                + Transaksi Penjualan Baru
            </a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success rounded-3">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger rounded-3">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID Nota</th>
                            <th>Waktu Transaksi</th>
                            <th>Kasir / Petugas</th>
                            <th>Margin Aktif</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-end">PPN (11%)</th>
                            <th class="text-end">Total Bayar</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penjualans as $p)
                            <tr>
                                <td class="fw-bold">#{{ $p->idpenjualan }}</td>
                                <td>{{ $p->created_at }}</td>
                                <td>{{ $p->username ?? 'Admin' }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $p->margin_persen ?? 0 }}%
                                    </span>
                                </td>
                                <td class="text-end">Rp {{ number_format($p->subtotal_nilai, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($p->ppn, 0, ',', '.') }}</td>
                                <td class="text-end fw-bold text-primary">
                                    Rp {{ number_format($p->total_nilai, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success">Selesai</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('penjualan.detail', $p->idpenjualan) }}" class="btn btn-outline-primary btn-sm rounded-3">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    Belum ada transaksi penjualan. Klik tombol <strong>+ Transaksi Penjualan Baru</strong> untuk memulai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
