<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengadaan - SIMBA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary-blue: #0284c7; --primary-blue-hover: #0369a1; --bg-body: #f8fafc; --text-dark: #1e293b; }
        body { font-family: 'Nunito', sans-serif; background-color: var(--bg-body); color: var(--text-dark); margin: 0; padding: 0; overflow-x: hidden; }
        .top-navbar { background-color: var(--primary-blue); height: 60px; padding: 0 1.5rem; display: flex; align-items: center; justify-content: space-between; }
        .brand-text { color: #ffffff; font-weight: 800; font-size: 1.25rem; text-decoration: none; }
        .sidebar { width: 230px; min-height: calc(100vh - 60px); background-color: #ffffff; border-right: 1px solid #f0f0f0; padding-top: 1.5rem; flex-shrink: 0; }
        .sidebar-link { display: flex; align-items: center; gap: 12px; padding: 10px 1.5rem; color: #555555; text-decoration: none; font-weight: 600; font-size: 0.9rem; }
        .sidebar-link:hover, .sidebar-link.active { color: var(--primary-blue); }
        .sidebar-link.active { font-weight: 800; }
        .menu-heading { padding: 1rem 1.5rem 0.25rem; font-size: 0.72rem; font-weight: 800; color: #aaaaaa; letter-spacing: 0.5px; }
        .main-wrapper { padding: 2rem; flex-grow: 1; }
        .card-panel { background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 1.5rem; }
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
                <li><a href="/penjualan" class="sidebar-link"><i class="fa-solid fa-cash-register"></i><span>Penjualan</span></a></li>
                <li><a href="/kartu-stok" class="sidebar-link"><i class="fa-solid fa-clipboard-list"></i><span>Kartu Stok</span></a></li>
                <li class="menu-heading">PENGATURAN</li>
                <li><a href="{{ route('margin-penjualan.index') }}" class="sidebar-link"><i class="fa-solid fa-percent"></i><span>Margin Penjualan</span></a></li>
            </ul>
        </aside>

        <main class="main-wrapper">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1">Buat Purchase Order (Multi-Barang)</h3>
                    <p class="text-secondary small mb-0">Harga dasar otomatis mengacu pada Master Barang (<code>view_barang</code>)</p>
                </div>
                <a href="{{ route('pengadaan.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
            </div>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card-panel">
                <form action="{{ route('pengadaan.store') }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-secondary">Vendor Rekanan</label>
                            <select name="idvendor" class="form-select" required>
                                <option value="">-- Pilih Vendor --</option>
                                @foreach ($vendors as $v)
                                    <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-secondary">Petugas Pembuat PO</label>
                            <select name="iduser" class="form-select">
                                <option value="">-- Otomatis / Pilih Petugas --</option>
                                @foreach ($users as $u)
                                    <option value="{{ $u->iduser }}">{{ $u->username }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold mb-0">Daftar Barang Dipesan</h6>
                        <button type="button" id="btn-tambah-po" class="btn btn-primary btn-sm fw-bold">
                            <i class="fa-solid fa-plus me-1"></i> Tambah Barang
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 38%">Barang</th>
                                    <th style="width: 22%">Harga Master</th>
                                    <th style="width: 15%">Jumlah</th>
                                    <th style="width: 20%">Sub Total</th>
                                    <th style="width: 5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="body-po">
                                <tr class="baris-po">
                                    <td>
                                        <select name="idbarang[]" class="form-select select-barang-po" required>
                                            <option value="" data-harga="0">-- Pilih Barang --</option>
                                            @foreach ($barangs as $b)
                                                <option value="{{ $b->idbarang }}" data-harga="{{ $b->harga }}">
                                                    {{ $b->nama_barang }} ({{ $b->nama_satuan ?? 'Unit' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control input-harga-po bg-light" value="Rp 0" readonly></td>
                                    <td><input type="number" name="jumlah[]" class="form-control input-qty-po" min="1" value="1" required></td>
                                    <td><input type="text" class="form-control input-sub-po bg-light fw-semibold" value="Rp 0" readonly></td>
                                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-hapus-po" disabled>&times;</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end mt-3">
                        <div class="col-md-4">
                            <table class="table table-sm table-borderless">
                                <tr><th>Subtotal:</th><td class="text-end" id="po-subtotal">Rp 0</td></tr>
                                <tr><th>PPN (11%):</th><td class="text-end" id="po-ppn">Rp 0</td></tr>
                                <tr class="border-top fs-5 fw-bold"><th>Total PO:</th><td class="text-end text-primary" id="po-total">Rp 0</td></tr>
                            </table>
                        </div>
                    </div>

                    <div class="text-end mt-3 pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-4 fw-bold" style="background-color: var(--primary-blue); border: none;">
                            Simpan Pengadaan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const bodyPO    = document.getElementById('body-po');
        const btnTambah = document.getElementById('btn-tambah-po');
        const formatRp  = n => 'Rp ' + Number(n).toLocaleString('id-ID');

        function hitungPO() {
            let subAll = 0;
            document.querySelectorAll('.baris-po').forEach(row => {
                const sel   = row.querySelector('.select-barang-po');
                const harga = Number(sel.options[sel.selectedIndex]?.dataset.harga || 0);
                const qty   = Number(row.querySelector('.input-qty-po').value || 0);
                const sub   = harga * qty;
                row.querySelector('.input-harga-po').value = formatRp(harga);
                row.querySelector('.input-sub-po').value   = formatRp(sub);
                subAll += sub;
            });
            const ppn = Math.round(subAll * 0.11);
            document.getElementById('po-subtotal').innerText = formatRp(subAll);
            document.getElementById('po-ppn').innerText      = formatRp(ppn);
            document.getElementById('po-total').innerText    = formatRp(subAll + ppn);

            const btns = document.querySelectorAll('.btn-hapus-po');
            btns.forEach(b => b.disabled = (btns.length === 1));
        }

        btnTambah.addEventListener('click', () => {
            const clone = bodyPO.querySelector('.baris-po').cloneNode(true);
            clone.querySelector('.select-barang-po').selectedIndex = 0;
            clone.querySelector('.input-harga-po').value = 'Rp 0';
            clone.querySelector('.input-qty-po').value   = 1;
            clone.querySelector('.input-sub-po').value   = 'Rp 0';
            bodyPO.appendChild(clone);
            hitungPO();
        });

        bodyPO.addEventListener('change', e => { if (e.target.classList.contains('select-barang-po')) hitungPO(); });
        bodyPO.addEventListener('input', e => { if (e.target.classList.contains('input-qty-po')) hitungPO(); });
        bodyPO.addEventListener('click', e => {
            if (e.target.classList.contains('btn-hapus-po')) {
                e.target.closest('.baris-po').remove();
                hitungPO();
            }
        });
    });
    </script>
</body>
</html>