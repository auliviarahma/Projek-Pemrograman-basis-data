<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengadaan - SIMBA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0284c7;
            --bg-body: #f8fafc;
            --text-dark: #1e293b;
        }
        body { font-family: 'Nunito', sans-serif; background-color: var(--bg-body); color: var(--text-dark); margin: 0; }
        .top-navbar { background-color: var(--primary-blue); height: 60px; padding: 0 1.5rem; display: flex; align-items: center; justify-content: space-between; }
        .brand-text { color: #ffffff; font-weight: 800; font-size: 1.25rem; text-decoration: none; }
        .sidebar { width: 230px; min-height: calc(100vh - 60px); background-color: #ffffff; border-right: 1px solid #f0f0f0; padding-top: 1.5rem; }
        .sidebar-link { display: flex; align-items: center; gap: 12px; padding: 10px 1.5rem; color: #555555; text-decoration: none; font-weight: 600; font-size: 0.9rem; }
        .sidebar-link:hover, .sidebar-link.active { color: var(--primary-blue); }
        .sidebar-link.active { font-weight: 800; }
        .menu-heading { padding: 1rem 1.5rem 0.25rem; font-size: 0.72rem; font-weight: 800; color: #aaaaaa; }
        .main-wrapper { padding: 2rem; flex-grow: 1; }
        .card-table { background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
        .table thead th { background-color: #f1f5f9; color: #475569; font-weight: 700; font-size: 0.82rem; padding: 12px 16px; border-bottom: 1px solid #e2e8f0; text-transform: uppercase; }
        .table tbody td { padding: 12px 16px; vertical-align: middle; font-size: 0.9rem; }
        .btn-blue { background-color: var(--primary-blue); color: #fff; font-weight: 700; border-radius: 6px; }
        .btn-blue:hover { background-color: #0369a1; color: #fff; }
    </style>
</head>
<body>
    <header class="top-navbar">
        <a href="/" class="brand-text">SIMBA</a>
        <div class="text-white d-flex align-items-center gap-3">
            <i class="fa-regular fa-bell"></i>
            <i class="fa-regular fa-user"></i>
        </div>
    </header>

    <div class="d-flex">
        <aside class="sidebar">
            <ul class="list-unstyled p-0 m-0">
                <li><a href="/" class="sidebar-link"><i class="fa-solid fa-chart-line"></i><span>Dashboard</span></a></li>
                <li class="menu-heading">TRANSAKSI</li>
                <li><a href="/pengadaan" class="sidebar-link active"><i class="fa-solid fa-cart-shopping" style="color: var(--primary-blue);"></i><span>Pengadaan</span></a></li>
                <li><a href="/penerimaan" class="sidebar-link"><i class="fa-solid fa-truck-ramp-box"></i><span>Penerimaan</span></a></li>
                <li><a href="/kartu-stok" class="sidebar-link"><i class="fa-solid fa-clipboard-list"></i><span>Kartu Stok</span></a></li>
            </ul>
        </aside>

        <main class="main-wrapper">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div>
                    <h3 class="fw-bold mb-1" style="color: #0f172a;">Data Pengadaan Barang</h3>
                    <p class="text-secondary small mb-0">Sumber data: <strong>SQL View (v_pengadaan)</strong></p>
                </div>
                <a href="/pengadaan/create" class="btn btn-blue btn-sm px-3">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Pengadaan
                </a>
            </div>

            <div class="card-table">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID PO</th>
                                <th>Tanggal</th>
                                <th>Vendor</th>
                                <th>Nama Barang</th>
                                <th class="text-end">Jumlah</th>
                                <th class="text-end">Harga Satuan</th>
                                <th class="text-end">Subtotal</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataPengadaan as $item)
                                <tr>
                                    <td class="fw-bold text-primary">#{{ $item->idpengadaan }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->nama_vendor }}</td>
                                    <td class="fw-semibold">{{ $item->nama_barang }}</td>
                                    <td class="text-end">{{ number_format($item->jumlah_beli) }}</td>
                                    <td class="text-end">Rp{{ number_format($item->harga_satuan) }}</td>
                                    <td class="text-end fw-bold">Rp{{ number_format($item->sub_total) }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $item->username }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">Belum ada data di view v_pengadaan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>