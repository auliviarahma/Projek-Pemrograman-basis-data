<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengadaan #{{ $header->idpengadaan }} - SIMBA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary-blue: #0284c7; --bg-body: #f8fafc; --text-dark: #1e293b; }
        body { font-family: 'Nunito', sans-serif; background-color: var(--bg-body); color: var(--text-dark); margin: 0; }
        .top-navbar { background-color: var(--primary-blue); height: 60px; padding: 0 1.5rem; display: flex; align-items: center; justify-content: space-between; }
        .brand-text { color: #ffffff; font-weight: 800; font-size: 1.25rem; text-decoration: none; }
        .sidebar { width: 230px; min-height: calc(100vh - 60px); background-color: #ffffff; border-right: 1px solid #f0f0f0; padding-top: 1.5rem; flex-shrink: 0; }
        .sidebar-link { display: flex; align-items: center; gap: 12px; padding: 10px 1.5rem; color: #555555; text-decoration: none; font-weight: 600; font-size: 0.9rem; }
        .sidebar-link.active { color: var(--primary-blue); font-weight: 800; }
        .menu-heading { padding: 1rem 1.5rem 0.25rem; font-size: 0.72rem; font-weight: 800; color: #aaaaaa; }
        .main-wrapper { padding: 2rem; flex-grow: 1; }
        .card-panel { background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 1.5rem; }
    </style>
</head>
<body>
    <header class="top-navbar">
        <a href="/" class="brand-text">SIMBA</a>
    </header>
    <div class="d-flex">
        <aside class="sidebar">
            <ul class="list-unstyled p-0 m-0">
                <li><a href="/" class="sidebar-link"><i class="fa-solid fa-chart-line"></i><span>Dashboard</span></a></li>
                <li class="menu-heading">TRANSAKSI</li>
                <li><a href="/pengadaan" class="sidebar-link active"><i class="fa-solid fa-cart-shopping" style="color: var(--primary-blue);"></i><span>Pengadaan</span></a></li>
                <li><a href="/penerimaan" class="sidebar-link"><i class="fa-solid fa-truck-ramp-box"></i><span>Penerimaan</span></a></li>
                <li><a href="/penjualan" class="sidebar-link"><i class="fa-solid fa-cash-register"></i><span>Penjualan</span></a></li>
                <li><a href="/kartu-stok" class="sidebar-link"><i class="fa-solid fa-clipboard-list"></i><span>Kartu Stok</span></a></li>
            </ul>
        </aside>
        <main class="main-wrapper">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1">Detail Purchase Order #{{ $header->idpengadaan }}</h3>
                    <p class="text-secondary small mb-0">Vendor: <strong>{{ $header->nama_vendor }}</strong> | Tanggal: {{ $header->created_at }}</p>
                </div>
                <a href="{{ route('pengadaan.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
            </div>
            <div class="card-panel">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th class="text-end">Harga Satuan</th>
                            <th class="text-center">Jumlah Pesan</th>
                            <th class="text-end">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($details as $i => $d)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $d->nama_barang }}</td>
                                <td class="text-end">Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $d->jumlah }}</td>
                                <td class="text-end fw-semibold">Rp {{ number_format($d->sub_total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr><th colspan="4" class="text-end">Subtotal</th><th class="text-end">Rp {{ number_format($header->subtotal_nilai, 0, ',', '.') }}</th></tr>
                        <tr><th colspan="4" class="text-end">PPN (11%)</th><th class="text-end">Rp {{ number_format($header->ppn, 0, ',', '.') }}</th></tr>
                        <tr class="text-primary fs-6"><th colspan="4" class="text-end">Total Nilai PO</th><th class="text-end">Rp {{ number_format($header->total_nilai, 0, ',', '.') }}</th></tr>
                    </tfoot>
                </table>
            </div>
        </main>
    </div>
</body>
</html>