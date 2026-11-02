<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Penerimaan - SIMBA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #0284c7;
            --primary-blue-hover: #0369a1;
            --table-header-blue: #0077b6;
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

        .card-panel {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .card-panel-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 1.25rem;
        }

        .table-custom-header thead th {
            background-color: var(--table-header-blue) !important;
            color: #ffffff !important;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 12px 16px;
            border: none;
            letter-spacing: 0.3px;
        }

        .table-custom-header tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            font-size: 0.88rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .btn-action-view {
            background-color: #0284c7;
            color: #ffffff;
            font-size: 0.78rem;
            font-weight: 700;
            border-radius: 4px;
            padding: 4px 12px;
            border: none;
            text-decoration: none;
        }

        .btn-action-view:hover {
            background-color: #0369a1;
            color: #ffffff;
        }

        .btn-action-edit {
            background-color: #64748b;
            color: #ffffff;
            font-size: 0.78rem;
            font-weight: 700;
            border-radius: 4px;
            padding: 4px 12px;
            border: none;
            text-decoration: none;
        }

        .btn-action-edit:hover {
            background-color: #475569;
            color: #ffffff;
        }

        .btn-action-delete {
            background-color: #ef4444;
            color: #ffffff;
            font-size: 0.78rem;
            font-weight: 700;
            border-radius: 4px;
            padding: 4px 12px;
            border: none;
        }

        .btn-action-delete:hover {
            background-color: #dc2626;
        }
    </style>
</head>
<body>

    <header class="top-navbar">
        <a href="/" class="brand-text">SIMBA</a>
        <div class="search-box d-none d-md-block">
            <input type="text" placeholder="Cari di tabel aktif...">
        </div>
        <div class="nav-icons">
            <i class="fa-regular fa-bell"></i>
            <i class="fa-regular fa-user"></i>
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
        </div>
    </header>

    <div class="d-flex">
        <aside class="sidebar">
            <ul class="list-unstyled p-0 m-0">
                <li>
                    <a href="/" class="sidebar-link">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="menu-heading">TRANSAKSI</li>
                <li>
                    <a href="/pengadaan" class="sidebar-link">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Pengadaan</span>
                    </a>
                </li>
                <li>
                    <a href="/penerimaan" class="sidebar-link active">
                        <i class="fa-solid fa-truck-ramp-box" style="color: var(--primary-blue);"></i>
                        <span>Penerimaan</span>
                    </a>
                </li>
                <li>
                    <a href="/kartu-stok" class="sidebar-link">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <span>Kartu Stok</span>
                    </a>
                </li>
                <li class="menu-heading">PENGATURAN</li>
                <li>
                    <a href="{{ route('margin-penjualan.index') }}" class="sidebar-link">
                        <i class="fa-solid fa-percent"></i>
                        <span>Margin Penjualan</span>
                    </a>
                </li>
            </ul>
        </aside>

        <main class="main-wrapper">
            <h3 class="fw-bold mb-4" style="color: #0f172a; letter-spacing: -0.5px;">Transaksi Penerimaan</h3>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card-panel">
                <div class="card-panel-title">Tambah Penerimaan</div>
                <form action="{{ route('penerimaan.store') }}" method="POST">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-lg-5 col-md-6 mb-3 mb-lg-0">
                            <label class="form-label text-muted small fw-bold mb-1">PENGADAAN</label>
                            <select name="idpengadaan" class="form-select" required>
                                <option value="">-- Pilih No Pengadaan --</option>
                                @foreach ($pengadaans as $po)
                                    <option value="{{ $po->idpengadaan }}" {{ $po->is_selesai ? 'disabled' : '' }}>
                                        PO #{{ $po->idpengadaan }} - {{ $po->nama_vendor ?? 'Vendor #' . $po->vendor_idvendor }}
                                        {{ $po->is_selesai ? '(SELESAI - SEMUA TELAH DITERIMA)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                            <label class="form-label text-muted small fw-bold mb-1">DITERIMA OLEH (USER)</label>
                            <select name="iduser" class="form-select" required>
                                <option value="">-- Pilih Petugas Penerima --</option>
                                @foreach ($users as $u)
                                    <option value="{{ $u->iduser }}">
                                        {{ $u->username }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-12 text-lg-end">
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="background-color: var(--primary-blue); border: none;">
                                Tambah Penerimaan
                            </button>
                        </div>
                    </div>
                    <div class="text-muted small mt-2" style="font-size: 0.72rem; letter-spacing: 0.3px;">
                        PENGADAAN YANG SUDAH SEMUA DITERIMA DITANDAI SEBAGAI &quot;SELESAI&quot; DAN TIDAK BISA DIPILIH
                    </div>
                </form>
            </div>

            <div class="card-panel p-0 overflow-hidden">
                <div class="p-3 bg-white border-bottom">
                    <div class="card-panel-title mb-0">Header Penerimaan</div>
                </div>
                <div class="table-responsive">
                    <table class="table table-custom-header mb-0">
                        <thead>
                            <tr>
                                <th style="width: 70px;">ID</th>
                                <th>TANGGAL</th>
                                <th>VENDOR</th>
                                <th>PETUGAS</th>
                                <th class="text-center" style="width: 100px;">STATUS</th>
                                <th class="text-end">TOTAL</th>
                                <th class="text-center" style="width: 220px;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($headerPenerimaan as $item)
                                <tr>
                                    <td class="fw-bold">{{ $item->idpenerimaan }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td class="fw-semibold">{{ $item->nama_vendor ?? '-' }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $item->username ?? 'admin' }}</span></td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border">{{ $item->status ?? 'F' }}</span>
                                    </td>
                                    <td class="text-end fw-bold">Rp{{ number_format($item->total_nilai ?? 0) }}</td>
                                    <td class="text-center">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('penerimaan.detail', $item->idpenerimaan) }}" class="btn-action-view">
                                                Lihat
                                            </a>
                                            <a href="{{ route('penerimaan.edit', $item->idpenerimaan) }}" class="btn-action-edit">
                                                Ubah
                                            </a>
                                            <form action="{{ route('penerimaan.destroy', $item->idpenerimaan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data penerimaan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action-delete">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        Belum ada data penerimaan.
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