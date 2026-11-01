<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Stok - SIMBA</title>

    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #0284c7;
            --blue-outline: #bae6fd;
            --bg-body: #f8fafc;
            --text-dark: #1e293b;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
        }

        .top-navbar {
            background-color: var(--primary-blue);
            height: 60px;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-text {
            color: #ffffff;
            font-weight: 800;
            font-size: 1.25rem;
            text-decoration: none;
        }

        .sidebar {
            width: 230px;
            min-height: calc(100vh - 60px);
            background-color: #ffffff;
            border-right: 1px solid #f0f0f0;
            padding-top: 1.5rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 1.5rem;
            color: #555555;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .sidebar-link:hover, .sidebar-link.active {
            color: var(--primary-blue);
        }

        .sidebar-link.active {
            font-weight: 800;
        }

        .accordion-btn-custom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 10px 1.5rem;
            border: none;
            background: transparent;
            color: #555555;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .accordion-btn-custom:hover {
            color: var(--primary-blue);
        }

        .sub-link {
            display: block;
            padding: 6px 1.5rem 6px 3rem;
            color: #777777;
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .sub-link:hover {
            color: var(--primary-blue);
        }

        .menu-heading {
            padding: 1rem 1.5rem 0.25rem;
            font-size: 0.72rem;
            font-weight: 800;
            color: #aaaaaa;
            letter-spacing: 0.5px;
        }

        .main-wrapper {
            padding: 2rem;
            flex-grow: 1;
        }

        .card-table {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            overflow: hidden;
        }

        .table thead th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: 700;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 16px;
        }

        .table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            font-size: 0.9rem;
        }

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

        .badge-retur {
            background-color: #fef3c7;
            color: #b45309;
            font-weight: 700;
        }
    </style>
</head>
<body>

    <!-- TOP NAVBAR -->
    <header class="top-navbar">
        <a href="/" class="brand-text">SIMBA</a>
        <div class="text-white d-flex align-items-center gap-3">
            <i class="fa-regular fa-bell"></i>
            <i class="fa-regular fa-user"></i>
        </div>
    </header>

    <div class="d-flex">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <ul class="nav-item p-0 m-0">
                <li>
                    <a href="/" class="sidebar-link">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- MASTER DATA -->
                <li>
                    <button class="accordion-btn-custom" type="button" data-bs-toggle="collapse" data-bs-target="#anakMasterData" aria-expanded="false">
                        <span><i class="fa-regular fa-folder me-2"></i> Master Data</span>
                        <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i>
                    </button>
                    <div class="collapse" id="anakMasterData">
                        <a href="/satuan" class="sub-link">Master Satuan</a>
                        <a href="/barang" class="sub-link">Master Barang</a>
                        <a href="/vendor" class="sub-link">Master Vendor</a>
                        <a href="/role" class="sub-link">Master Role</a>
                        <a href="/user" class="sub-link">Master User</a>
                        <a href="/margin-penjualan" class="sub-link">Margin Penjualan</a>
                    </div>
                </li>

                <!-- TRANSAKSI -->
                <li class="menu-heading">TRANSAKSI</li>
                <li>
                    <a href="/kartu-stok" class="sidebar-link active">
                        <i class="fa-solid fa-clipboard-list" style="color: var(--primary-blue);"></i>
                        <span>Kartu Stok</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- KONTEN BUKTI HASIL MUTASI DARI TRIGGER -->
        <main class="main-wrapper">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div>
                    <h3 class="fw-bold mb-1" style="color: #0f172a;">Buku Besar Kartu Stok</h3>
                    <p class="text-secondary small mb-0">Catatan otomatisasi mutasi stok yang dieksekusi langsung oleh Trigger MySQL</p>
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
                                        @elseif ($row->jenis_transaksi == 'R')
                                            <span class="badge badge-retur px-2 py-1">R - Retur</span>
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
                                    <td class="text-center text-muted">#{{ $row->idtransaksi }}</td>
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
        </main>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>