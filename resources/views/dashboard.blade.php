<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi dan Manajemen Barang</title>

    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #0284c7;        /* Biru utama di navbar & tombol */
            --primary-blue-hover: #0369a1;
            --blue-outline: #bae6fd;        /* Biru muda untuk border */
            --bg-body: #f8fafc;             /* Latar abu-abu sangat muda */
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

        /* Top Navbar Biru Utama */
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

        /* Sidebar Kiri Putih */
        .sidebar {
            width: 230px;
            min-height: calc(100vh - 60px);
            background-color: #ffffff;
            border-right: 1px solid #f0f0f0;
            padding-top: 1.5rem;
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

        /* Submenu Akordeon Master Data */
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

        /* Kategori Transaksi */
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

        /* Kartu Aksen Biru Tipis */
        .card-blue-outline {
            background-color: #ffffff;
            border: 1px solid var(--blue-outline);
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.05);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-blue-outline .label-title {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: var(--primary-blue);
            margin-bottom: 0.35rem;
        }

        .card-blue-outline .metric-value {
            font-size: 1.85rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 0.4rem;
            color: var(--text-dark);
        }

        .card-blue-outline .footer-desc {
            font-size: 0.75rem;
            color: #64748b;
        }

        /* Kartu Putih Biasa */
        .card-white-clean {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 1.25rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-white-clean h6 {
            color: var(--text-dark);
            font-weight: 700;
        }

        /* Tombol Outline Biru */
        .btn-blue-outline {
            color: var(--primary-blue);
            border: 1px solid var(--primary-blue);
            background-color: transparent;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 4px 12.5px;
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
                    <a href="/" class="sidebar-link active">
                        <i class="fa-solid fa-chart-line" style="color: var(--primary-blue);"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- DROPDOWN MASTER DATA -->
                <li>
                    <button class="accordion-btn-custom" type="button" data-bs-toggle="collapse" data-bs-target="#anakMasterData" aria-expanded="true">
                        <span><i class="fa-regular fa-folder me-2"></i> Master Data</span>
                        <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i>
                    </button>
                    <div class="collapse show" id="anakMasterData">
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
                    <a href="/kartu-stok" class="sidebar-link">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <span>Kartu Stok</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- KONTEN UTAMA KANAN -->
        <main class="main-wrapper">
            <!-- Header Judul & Badge Database -->
            <div class="d-flex justify-content-between align-items-start mb-4 pb-2 border-bottom">
                <div>
                    <h3 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Dashboard</h3>
                    <p class="text-secondary small mb-0">SISTEM INFORMASI DAN MANAJEMEN BARANG</p>
                </div>
                <span class="badge bg-white text-secondary border px-3 py-2 fw-semibold">Database: projekpbd</span>
            </div>

            <!-- ROW 1: 3 KARTU DENGAN AKSEN/BORDER BIRU -->
            <div class="row g-4 mb-4">
                <!-- Satuan -->
                <div class="col-md-4">
                    <div class="card-blue-outline">
                        <div>
                            <div class="label-title">MASTER SATUAN</div>
                            <div class="metric-value">{{ $totalSatuan ?? 5 }} Data</div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2">
                            <span class="footer-desc">Unit logistik aktif</span>
                            <a href="/satuan" class="btn-blue-outline">Buka</a>
                        </div>
                    </div>
                </div>

                <!-- Barang -->
                <div class="col-md-4">
                    <div class="card-blue-outline">
                        <div>
                            <div class="label-title">MASTER BARANG</div>
                            <div class="metric-value">{{ $totalBarang ?? 5 }} Produk</div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2">
                            <span class="footer-desc">Katalog bahan baku & jadi</span>
                            <a href="/barang" class="btn-blue-outline">Buka</a>
                        </div>
                    </div>
                </div>

                <!-- Margin Penjualan -->
                <div class="col-md-4">
                    <div class="card-blue-outline">
                        <div>
                            <div class="label-title">MARGIN PENJUALAN</div>
                            <div class="metric-value">{{ $totalMargin ?? 5 }} Aturan</div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2">
                            <span class="footer-desc">Persentase laba aktif</span>
                            <a href="/margin" class="btn-blue-outline">Buka</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ROW 2: KARTU TAMBAHAN (VENDOR, ROLE, USER) -->
            <div class="row g-4">
                <!-- Vendor -->
                <div class="col-md-4">
                    <div class="card-white-clean">
                        <div>
                            <h6 class="mb-1 text-muted" style="font-size: 0.8rem; letter-spacing: 0.3px; font-weight: 700;">MASTER VENDOR</h6>
                            <h3 class="fw-bold mb-0 text-dark" style="font-size: 1.85rem;">{{ $totalVendor ?? 5 }}</h3>
                        </div>
                        <div class="pt-3 border-top mt-3 text-end">
                            <a href="/vendor" class="btn-blue-outline">Kelola Vendor</a>
                        </div>
                    </div>
                </div>

                <!-- Role -->
                <div class="col-md-4">
                    <div class="card-white-clean">
                        <div>
                            <h6 class="mb-1 text-muted" style="font-size: 0.8rem; letter-spacing: 0.3px; font-weight: 700;">MASTER ROLE</h6>
                            <h3 class="fw-bold mb-0 text-dark" style="font-size: 1.85rem;">{{ $totalRole ?? 11 }}</h3>
                        </div>
                        <div class="pt-3 border-top mt-3 text-end">
                            <a href="/role" class="btn-blue-outline">Kelola Role</a>
                        </div>
                    </div>
                </div>

                <!-- User -->
                <div class="col-md-4">
                    <div class="card-white-clean">
                        <div>
                            <h6 class="mb-1 text-muted" style="font-size: 0.8rem; letter-spacing: 0.3px; font-weight: 700;">MASTER USER</h6>
                            <h3 class="fw-bold mb-0 text-dark" style="font-size: 1.85rem;">{{ $totalUser ?? 7 }}</h3>
                        </div>
                        <div class="pt-3 border-top mt-3 text-end">
                            <a href="/user" class="btn-blue-outline">Kelola User</a>
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