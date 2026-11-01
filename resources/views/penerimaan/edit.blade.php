<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penerimaan #{{ $penerimaan->idpenerimaan }} - SIMBA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary-blue: #0284c7; --bg-body: #f8fafc; --text-dark: #1e293b; }
        body { font-family: 'Nunito', sans-serif; background-color: var(--bg-body); color: var(--text-dark); margin: 0; }
        .top-navbar { background-color: var(--primary-blue); height: 60px; padding: 0 1.5rem; display: flex; align-items: center; justify-content: space-between; }
        .brand-text { color: #ffffff; font-weight: 800; font-size: 1.25rem; text-decoration: none; }
        .sidebar { width: 230px; min-height: calc(100vh - 60px); background-color: #ffffff; border-right: 1px solid #f0f0f0; padding-top: 1.5rem; }
        .sidebar-link { display: flex; align-items: center; gap: 12px; padding: 10px 1.5rem; color: #555555; text-decoration: none; font-weight: 600; font-size: 0.9rem; }
        .sidebar-link:hover, .sidebar-link.active { color: var(--primary-blue); }
        .sidebar-link.active { font-weight: 800; }
        .menu-heading { padding: 1rem 1.5rem 0.25rem; font-size: 0.72rem; font-weight: 800; color: #aaaaaa; }
        .main-wrapper { padding: 2rem; flex-grow: 1; }
        .card-form { background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.02); max-width: 650px; }
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
                <li><a href="/pengadaan" class="sidebar-link"><i class="fa-solid fa-cart-shopping"></i><span>Pengadaan</span></a></li>
                <li><a href="/penerimaan" class="sidebar-link active"><i class="fa-solid fa-truck-ramp-box" style="color: var(--primary-blue);"></i><span>Penerimaan</span></a></li>
                <li><a href="/kartu-stok" class="sidebar-link"><i class="fa-solid fa-clipboard-list"></i><span>Kartu Stok</span></a></li>
            </ul>
        </aside>

        <main class="main-wrapper">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div>
                    <h3 class="fw-bold mb-1" style="color: #0f172a;">Edit Penerimaan #{{ $penerimaan->idpenerimaan }}</h3>
                    <p class="text-secondary small mb-0">Perbarui informasi nomor PO pengadaan atau status transaksi</p>
                </div>
                <a href="{{ route('penerimaan.detail', $penerimaan->idpenerimaan) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Batal & Kembali
                </a>
            </div>

            <div class="card-form">
                <form action="{{ route('penerimaan.update', $penerimaan->idpenerimaan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nomor Referensi Pengadaan (PO)</label>
                        <select name="idpengadaan" class="form-select" required>
                            @foreach ($pengadaans as $p)
                                <option value="{{ $p->idpengadaan }}" {{ $penerimaan->idpengadaan == $p->idpengadaan ? 'selected' : '' }}>
                                    PO #{{ $p->idpengadaan }} - Vendor: {{ $p->nama_vendor ?? 'Vendor #' . $p->vendor_idvendor }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Status Transaksi</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $penerimaan->status == '1' ? 'selected' : '' }}>1 - Aktif / Diterima</option>
                            <option value="0" {{ $penerimaan->status == '0' ? 'selected' : '' }}>0 - Batal / Nonaktif</option>
                        </select>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-blue px-4">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>