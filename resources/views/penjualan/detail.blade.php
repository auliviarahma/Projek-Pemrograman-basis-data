

<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">Struk / Detail Penjualan #{{ $penjualan->idpenjualan }}</h5>
                <small class="text-muted">Status Transaksi: <span class="badge bg-success">Selesai</span></small>
            </div>
            <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary btn-sm rounded-3">Kembali</a>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Waktu Transaksi:</strong> {{ $penjualan->created_at }}</p>
                    <p class="mb-1"><strong>Kasir:</strong> {{ $penjualan->username ?? 'Admin' }}</p>
                    <p class="mb-0"><strong>Margin Diterapkan:</strong> {{ $penjualan->margin_persen ?? 0 }}%</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-1">Subtotal: Rp {{ number_format($penjualan->subtotal_nilai, 0, ',', '.') }}</p>
                    <p class="mb-1">PPN (11%): Rp {{ number_format($penjualan->ppn, 0, ',', '.') }}</p>
                    <h5 class="fw-bold text-primary mt-1">
                        Total Bayar: Rp {{ number_format($penjualan->total_nilai, 0, ',', '.') }}
                    </h5>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th class="text-end">Harga Satuan</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($details as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td class="text-end">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item->jumlah }}</td>
                                <td class="text-end fw-semibold">Rp {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
