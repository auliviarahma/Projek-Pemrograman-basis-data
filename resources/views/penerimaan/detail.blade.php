<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penerimaan #{{ $penerimaan->idpenerimaan }} - SIMBA</title>

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

        /* Top Navbar */
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

        .nav-icons i {
            cursor: pointer;
        }

        /* Sidebar Kiri */
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

        /* Konten Utama */
        .main-wrapper {
            padding: 2rem;
            flex-grow: 1;
        }

        .card-custom {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }

        .btn-blue {
            background-color: var(--primary-blue);
            color: #ffffff;
            font-weight: 700;
            border-radius: 6px;
            border: none;
            transition: all 0.2s;
        }

        .btn-blue:hover {
            background-color: var(--primary-blue-hover);
            color: #ffffff;
        }

        .table thead th {
            background-color: var(--primary-blue);
            color: #ffffff;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 10px 14px;
            border: none;
            text-transform: uppercase;
        }

        .table tbody td {
            padding: 12px 14px;
            vertical-align: middle;
            font-size: 0.88rem;
        }
    </style>
</head>
<body>

    <!-- TOP NAVBAR -->
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
            </ul>
        </aside>

        <!-- KONTEN UTAMA DUA KOLOM -->
        <main class="main-wrapper">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div>
                    <h3 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Detail Penerimaan #{{ $penerimaan->idpenerimaan }}</h3>
                    <p class="text-secondary small mb-0">Input fisik barang masuk berdasarkan Pengadaan PO #{{ $penerimaan->idpengadaan }}</p>
                </div>
                <a href="/penerimaan" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Penerimaan
                </a>
            </div>

            <!-- Notifikasi Sukses / Gagal -->
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

            <div class="row g-4">
                <!-- KOLOM KIRI: RINGKASAN TRANSAKSI -->
                <div class="col-lg-5">
                    <div class="card-custom h-100">
                        <h5 class="fw-bold mb-3 border-bottom pb-2">Ringkasan</h5>
                        
                        <table class="table table-borderless table-sm mb-4">
                            <tr>
                                <td class="text-muted" style="width: 120px;">Vendor:</td>
                                <td class="fw-bold">{{ $penerimaan->nama_vendor ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Pengadaan:</td>
                                <td class="fw-bold">#{{ $penerimaan->idpengadaan }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tanggal:</td>
                                <td>{{ $penerimaan->created_at }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Dibuat oleh:</td>
                                <td>{{ $penerimaan->username ?? 'admin' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Status:</td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                        Aktif ({{ $penerimaan->status }})
                                    </span>
                                </td>
                            </tr>
                        </table>

                        <div class="p-3 bg-light rounded-3 mb-4 border">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Subtotal:</span>
                                <span class="fw-semibold">Rp{{ number_format($penerimaan->subtotal_nilai ?? 0) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">PPN (11%):</span>
                                <span class="fw-semibold">Rp{{ number_format($penerimaan->ppn ?? 0) }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-2">
                                <span class="fw-bold text-dark">Total:</span>
                                <span class="fw-bold text-primary fs-5">Rp{{ number_format($penerimaan->total_nilai ?? 0) }}</span>
                            </div>
                        </div>

                        <!-- Tombol Aksi Header & Mutasi Stok -->
                        <div class="d-flex flex-column gap-2">
                            <a href="/kartu-stok" class="btn btn-outline-primary w-100 fw-bold">
                                <i class="fa-solid fa-clipboard-list me-1"></i> Cek Mutasi Kartu Stok
                            </a>
                            <div class="d-flex gap-2">
                                <a href="{{ route('penerimaan.edit', $penerimaan->idpenerimaan) }}" class="btn btn-warning w-50 fw-bold text-dark">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit Header
                                </a>
                                <form action="{{ route('penerimaan.destroy', $penerimaan->idpenerimaan) }}" method="POST" class="w-50" onsubmit="return confirm('Yakin ingin menghapus seluruh transaksi penerimaan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100 fw-bold">
                                        <i class="fa-solid fa-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN: TAMBAH DETAIL & TABEL BARANG MASUK -->
                <div class="col-lg-7">
                    <!-- Form Tambah Detail Barang (Tervalidasi Sesuai PO) -->
                    <div class="card-custom mb-4">
                        <h5 class="fw-bold mb-3 border-bottom pb-2">Tambah Detail</h5>
                        <form action="{{ route('penerimaan.detail.store', $penerimaan->idpenerimaan) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pilih Barang (Khusus PO #{{ $penerimaan->idpengadaan }})</label>
                                <select name="idbarang" class="form-select" required>
                                    <option value="">-- Pilih Barang dari PO --</option>
                                    @forelse ($barangsPO as $b)
                                        <option value="{{ $b->idbarang }}" {{ $b->sisa_kuota == 0 ? 'disabled' : '' }}>
                                            {{ $b->nama }} — Dipesan: {{ $b->jumlah_pesan }} | Sisa: {{ $b->sisa_kuota }}
                                            {{ $b->sisa_kuota == 0 ? '(Lengkap)' : '' }}
                                        </option>
                                    @empty
                                        <option value="" disabled>Tidak ada barang pada PO Pengadaan ini</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Jumlah Terima</label>
                                    <input type="number" name="jumlah_terima" class="form-control" placeholder="Contoh: 10" min="1" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Harga Satuan Terima (Rp)</label>
                                    <input type="number" name="harga_satuan_terima" class="form-control" placeholder="Contoh: 15000" min="0" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-blue w-100 py-2">
                                <i class="fa-solid fa-plus me-1"></i> Tambah Barang ke Detail Penerimaan
                            </button>
                        </form>
                    </div>

                    <!-- Tabel Daftar Detail Barang Masuk -->
                    <div class="card-custom p-0 overflow-hidden">
                        <div class="p-3 bg-light border-bottom">
                            <h6 class="fw-bold mb-0">Daftar Detail</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-3">ID</th>
                                        <th>BARANG</th>
                                        <th class="text-end">JUMLAH</th>
                                        <th class="text-end">HARGA</th>
                                        <th class="text-end">SUBTOTAL</th>
                                        <th class="text-center pe-3">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($details as $d)
                                        <tr>
                                            <td class="ps-3 fw-bold text-secondary">#{{ $d->iddetail_penerimaan }}</td>
                                            <td class="fw-semibold">{{ $d->nama_barang }}</td>
                                            <td class="text-end fw-bold text-success">+{{ number_format($d->jumlah_terima) }}</td>
                                            <td class="text-end">Rp{{ number_format($d->harga_satuan_terima) }}</td>
                                            <td class="text-end fw-bold text-dark">Rp{{ number_format($d->sub_total_terima) }}</td>
                                            <td class="text-center pe-3">
                                                <form action="{{ route('penerimaan.detail.destroy', $d->iddetail_penerimaan) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus barang ini dari daftar penerimaan?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" title="Hapus Item">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                Belum ada barang yang diterima pada transaksi ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>