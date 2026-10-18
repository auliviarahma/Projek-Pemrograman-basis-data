<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Simba - Master Data</title>
    <!-- Bootstrap 5 & Font Awesome Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            background: #f8fafc; 
            font-family: 'Inter', system-ui, -apple-system, sans-serif; 
            color: #1e293b;
        }
        .header-box {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
            border-radius: 20px;
            color: white;
            padding: 36px 32px;
            box-shadow: 0 10px 25px -5px rgba(49, 46, 129, 0.3);
        }
        .menu-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            transition: all 0.25s ease;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04);
        }
        .menu-card:hover {
            transform: translateY(-6px);
            border-color: #cbd5e1;
            box-shadow: 0 16px 24px -6px rgba(0, 0, 0, 0.08);
            color: inherit;
        }
        .icon-circle {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        /* Icon Colors */
        .icon-satuan { background: #e0e7ff; color: #4338ca; }
        .icon-barang { background: #dcfce7; color: #15803d; }
        .icon-vendor { background: #ffedd5; color: #c2410c; }
        .icon-role   { background: #fef3c7; color: #b45309; }
        .icon-user   { background: #f3e8ff; color: #7e22ce; }
        .icon-margin { background: #ffe4e6; color: #e11d48; }

        .stat-count {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1.2;
        }
        .badge-link {
            font-size: 0.8rem;
            font-weight: 600;
            color: #6366f1;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .menu-card:hover .badge-link {
            color: #4338ca;
            text-decoration: underline;
        }
    </style>
</head>
<body class="py-5">

<div class="container" style="max-width: 1080px;">

    <!-- Banner Sambutan -->
    <div class="header-box mb-5">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <span class="badge bg-indigo-500 text-uppercase tracking-wide px-3 py-2 rounded-pill mb-2" style="background: rgba(255,255,255,0.15); font-size: 0.75rem;">
                    Database Management System
                </span>
                <h2 class="fw-bold m-0 mt-1">Sistem Informasi Master Data</h2>
                <p class="text-white-50 m-0 mt-1" style="font-size: 0.95rem;">
                    Pilih modul data master di bawah ini untuk melihat, menambah, mengubah, atau menghapus data.
                </p>
            </div>
            <div>
                <span class="badge bg-white text-dark px-3 py-2 rounded-pill shadow-sm">
                    <i class="fa-solid fa-database text-primary me-1"></i> projekpbd
                </span>
            </div>
        </div>
    </div>

    <!-- Grid 6 Master Data (3 kolom per baris) -->
    <div class="row g-4">

        <!-- 1. Master Satuan -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('satuan.index') }}" class="menu-card">
                <div>
                    <div class="icon-circle icon-satuan">
                        <i class="fa-solid fa-ruler-combined"></i>
                    </div>
                    <h5 class="fw-bold mb-1">Master Satuan</h5>
                    <p class="text-muted small mb-3">Satuan takaran unit barang logistik</p>
                </div>
                <div class="d-flex justify-content-between align-items-end pt-3 border-top">
                    <div>
                        <div class="stat-count">{{ $totalSatuan }}</div>
                        <span class="text-muted small">Total Data</span>
                    </div>
                    <span class="badge-link">Buka <i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </a>
        </div>

        <!-- 2. Master Barang -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('barang.index') }}" class="menu-card">
                <div>
                    <div class="icon-circle icon-barang">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                    <h5 class="fw-bold mb-1">Master Barang</h5>
                    <p class="text-muted small mb-3">Katalog bahan baku dan produk jadi</p>
                </div>
                <div class="d-flex justify-content-between align-items-end pt-3 border-top">
                    <div>
                        <div class="stat-count">{{ $totalBarang }}</div>
                        <span class="text-muted small">Total Data</span>
                    </div>
                    <span class="badge-link">Buka <i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </a>
        </div>

        <!-- 3. Master Vendor -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('vendor.index') }}" class="menu-card">
                <div>
                    <div class="icon-circle icon-vendor">
                        <i class="fa-solid fa-truck-ramp-box"></i>
                    </div>
                    <h5 class="fw-bold mb-1">Master Vendor</h5>
                    <p class="text-muted small mb-3">Daftar mitra supplier dan badan usaha</p>
                </div>
                <div class="d-flex justify-content-between align-items-end pt-3 border-top">
                    <div>
                        <div class="stat-count">{{ $totalVendor }}</div>
                        <span class="text-muted small">Total Data</span>
                    </div>
                    <span class="badge-link">Buka <i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </a>
        </div>

        <!-- 4. Master Role -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('role.index') }}" class="menu-card">
                <div>
                    <div class="icon-circle icon-role">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <h5 class="fw-bold mb-1">Master Role</h5>
                    <p class="text-muted small mb-3">Wewenang dan hak otorisasi akun</p>
                </div>
                <div class="d-flex justify-content-between align-items-end pt-3 border-top">
                    <div>
                        <div class="stat-count">{{ $totalRole }}</div>
                        <span class="text-muted small">Total Data</span>
                    </div>
                    <span class="badge-link">Buka <i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </a>
        </div>

        <!-- 5. Master User -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('user.index') }}" class="menu-card">
                <div>
                    <div class="icon-circle icon-user">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>
                    <h5 class="fw-bold mb-1">Master User</h5>
                    <p class="text-muted small mb-3">Akun pengguna dan operator sistem</p>
                </div>
                <div class="d-flex justify-content-between align-items-end pt-3 border-top">
                    <div>
                        <div class="stat-count">{{ $totalUser }}</div>
                        <span class="text-muted small">Total Data</span>
                    </div>
                    <span class="badge-link">Buka <i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </a>
        </div>

        <!-- 6. Master Margin Penjualan -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('margin-penjualan.index') }}" class="menu-card">
                <div>
                    <div class="icon-circle icon-margin">
                        <i class="fa-solid fa-percent"></i>
                    </div>
                    <h5 class="fw-bold mb-1">Margin Penjualan</h5>
                    <p class="text-muted small mb-3">Persentase margin keuntungan produk</p>
                </div>
                <div class="d-flex justify-content-between align-items-end pt-3 border-top">
                    <div>
                        <div class="stat-count">{{ $totalMargin }}</div>
                        <span class="text-muted small">Total Data</span>
                    </div>
                    <span class="badge-link">Buka <i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>