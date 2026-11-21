<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan - SIMBA</title>

    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #0284c7;
            --primary-blue-hover: #0369a1;
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
            overflow-x: hidden;
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
            letter-spacing: -0.5px;
            text-decoration: none;
        }

        .search-box {
            position: relative;
            width: 320px;
        }

        .search-box input {
            border-radius: 6px;
            border: none;
            padding: 6px 14px;
            font-size: 0.85rem;
            width: 100%;
            outline: none;
        }

        .nav-icons {
            display: flex;
            align-items: center;
            gap: 18px;
            color: #ffffff;
            font-size: 1.1rem;
        }

        .sidebar {
            width: 230px;
            min-height: calc(100vh - 60px);
            background-color: #ffffff;
            border-right: 1px solid #f0f0f0;
            padding-top: 1.5rem;
            flex-shrink: 0;
        }

        .sidebar .nav-item {
            list-style: none;
            padding: 0;
            margin: 0;
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

        .card-white-clean {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }

        .btn-blue-primary {
            background-color: var(--primary-blue);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            padding: 8px 16px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-blue-primary:hover {
            background-color: var(--primary-blue-hover);
            color: #ffffff;
        }

        .btn-blue-outline {
            color: var(--primary-blue);
            border: 1px solid var(--primary-blue);
            background-color: transparent;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 4px 12px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-blue-outline:hover {
            background-color: var(--primary-blue);
            color: #ffffff;
        }
    </style>
</head>
<body>

    <!-- TOP NAVBAR BIRU -->
    <header class="top-navbar">
        <a href="/" class="brand-text">SIMBA</a>
        <div class="search-box d-none d-md-block">
            <input type="text" placeholder="Cari Master Data / Barang...">
        </div>
        <div class="nav-icons">
            <i class="fa-regular fa-bell"></i>
            <i class="fa-regular fa-user"></i>
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
        </div>
    </header>

    <div class="d-flex">
        <!-- SIDEBAR KIRI -->
        <aside class="sidebar">
            <ul class="nav-item p-0">
                <li>
                    <a href="/" class="sidebar-link">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- DROPDOWN MASTER DATA -->
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
                        <a href="/margin" class="sub-link">Margin Penjualan</a>
                    </div>
                </li>

                <!-- MENU TRANSAKSI -->
                <li class="menu-heading">TRANSAKSI</li>
                <li>
                    <a href="/pengadaan" class="sidebar-link">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Pengadaan</span>
                    </a>
                </li>
                <li>
                    <a href="/penerimaan" class="sidebar-link">
                        <i class="fa-solid fa-truck-ramp-box"></i>
                        <span>Penerimaan</span>
                    </a>
                </li>
                <li>
                    <a href="/penjualan" class="sidebar-link active">
                        <i class="fa-solid fa-cash-register" style="color: var(--primary-blue);"></i>
                        <span>Penjualan</span>
                    </a>
                </li>
                <li>
                    <a href="/kartu-stok" class="sidebar-link">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <span>Kartu Stok</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- KONTEN UTAMA KANAN -->
        <main class="main-wrapper">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div>
                    <h3 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Transaksi Penjualan</h3>
                    <p class="text-secondary small mb-0">Otomatis memotong kartu stok via Trigger MySQL</p>
                </div>
                <a href="{{ route('penjualan.create') }}" class="btn-blue-primary">
                    <i class="fa-solid fa-plus me-1"></i> Transaksi Penjualan Baru
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success rounded-3">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger rounded-3">{{ session('error') }}</div>
            @endif

            <div class="card-white-clean">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
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
                                        <a href="{{ route('penjualan.detail', $p->idpenjualan) }}" class="btn-blue-outline">
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
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>