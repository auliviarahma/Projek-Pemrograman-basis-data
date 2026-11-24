<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Penjualan - SIMBA</title>

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

        .btn-blue-outline {
            color: var(--primary-blue);
            border: 1px solid var(--primary-blue);
            background-color: transparent;
            border-radius: 6px;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 6px 14px;
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
                    <h3 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Kasir Penjualan (Multi-Barang)</h3>
                    <p class="text-secondary small mb-0">Harga jual dihitung otomatis melalui Stored Function <code>hitung_harga_jual()</code></p>
                </div>
                <a href="{{ route('penjualan.index') }}" class="btn-blue-outline">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            @if (session('error'))
                <div class="alert alert-danger rounded-3">
                    <strong>Gagal Transaksi:</strong> {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger rounded-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (!$marginAktif)
                <div class="alert alert-warning rounded-3">
                    <strong>Perhatian!</strong> Belum ada Margin Penjualan yang aktif. Silakan aktifkan salah satu margin di menu <strong>Margin Penjualan</strong> terlebih dahulu sebelum melakukan transaksi.
                </div>
            @endif

            <div class="card-white-clean">
                <form action="{{ route('penjualan.store') }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-secondary">Kasir / Petugas Pencatat</label>
                            <select name="iduser" class="form-select rounded-3">
                                <option value="">-- Otomatis / Pilih Kasir --</option>
                                @foreach ($users as $u)
                                    <option value="{{ $u->iduser }}">{{ $u->username }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-secondary">Margin Keuntungan Aktif Saat Ini</label>
                            <input type="text" class="form-control bg-light fw-bold text-success rounded-3" 
                                   value="{{ $marginAktif ? $marginAktif->persen . '% (ID Margin #' . $marginAktif->idmargin_penjualan . ')' : 'Tidak Ada Margin Aktif' }}" 
                                   readonly>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold mb-0">Item Barang Dibeli</h6>
                        <button type="button" id="btn-tambah-item" class="btn btn-primary btn-sm rounded-3 fw-bold">
                            <i class="fa-solid fa-plus me-1"></i> Tambah Item
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="tabel-penjualan">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 36%">Pilih Barang (Sisa Stok)</th>
                                    <th style="width: 22%">Harga Satuan (Function)</th>
                                    <th style="width: 15%">Jumlah Beli</th>
                                    <th style="width: 22%">Sub Total</th>
                                    <th style="width: 5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="body-penjualan">
                                <tr class="baris-jual">
                                    <td>
                                        <select name="idbarang[]" class="form-select select-barang-jual" required>
                                            <option value="" data-harga="0" data-stok="0">-- Pilih Barang --</option>
                                            @foreach ($barangs as $b)
                                                @php
                                                    $namaBrg = $b->nama_barang ?? ($b->nama ?? 'Barang #' . $b->idbarang);
                                                    $stokBrg = $b->stok_tersedia ?? ($b->stok ?? 0);
                                                @endphp
                                                <option value="{{ $b->idbarang }}" 
                                                        data-harga="{{ round($b->harga_jual) }}" 
                                                        data-stok="{{ $stokBrg }}"
                                                        {{ $stokBrg <= 0 ? 'disabled' : '' }}>
                                                    {{ $namaBrg }} (Stok: {{ $stokBrg }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control input-harga-jual bg-light" value="Rp 0" readonly>
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah[]" class="form-control input-qty-jual" min="1" value="1" required>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control input-sub-jual bg-light fw-semibold" value="Rp 0" readonly>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm btn-hapus-jual" disabled>&times;</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end mt-3">
                        <div class="col-md-4">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th>Subtotal:</th>
                                    <td class="text-end" id="lbl-subtotal">Rp 0</td>
                                </tr>
                                <tr>
                                    <th>PPN (11%):</th>
                                    <td class="text-end" id="lbl-ppn">Rp 0</td>
                                </tr>
                                <tr class="border-top fs-5 fw-bold">
                                    <th>Total Bayar:</th>
                                    <td class="text-end text-primary" id="lbl-total">Rp 0</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="text-end mt-3 pt-3 border-top">
                        <button type="submit" class="btn btn-success px-4 fw-bold rounded-3" {{ !$marginAktif ? 'disabled' : '' }}>
                            <i class="fa-solid fa-check me-1"></i> Proses & Selesaikan Penjualan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const bodyJual  = document.getElementById('body-penjualan');
        const btnTambah = document.getElementById('btn-tambah-item');

        function formatRp(angka) {
            return 'Rp ' + Number(angka).toLocaleString('id-ID');
        }

        function kalkulasiNota() {
            let subtotalSemua = 0;

            document.querySelectorAll('.baris-jual').forEach(row => {
                const select   = row.querySelector('.select-barang-jual');
                const inputQty = row.querySelector('.input-qty-jual');
                const opt      = select.options[select.selectedIndex];

                const harga = Number(opt?.dataset.harga || 0);
                const stok  = Number(opt?.dataset.stok || 0);

                if (select.value !== "") {
                    inputQty.max = stok;
                    if (Number(inputQty.value) > stok && stok > 0) {
                        inputQty.value = stok;
                    }
                } else {
                    inputQty.removeAttribute('max');
                }

                const qty = Number(inputQty.value || 0);
                const sub = harga * qty;

                row.querySelector('.input-harga-jual').value = formatRp(harga);
                row.querySelector('.input-sub-jual').value   = formatRp(sub);
                subtotalSemua += sub;
            });

            const ppn   = Math.round(subtotalSemua * 0.11);
            const total = subtotalSemua + ppn;

            document.getElementById('lbl-subtotal').innerText = formatRp(subtotalSemua);
            document.getElementById('lbl-ppn').innerText      = formatRp(ppn);
            document.getElementById('lbl-total').innerText    = formatRp(total);

            const tombolHapus = document.querySelectorAll('.btn-hapus-jual');
            tombolHapus.forEach(btn => btn.disabled = (tombolHapus.length === 1));
        }

        btnTambah.addEventListener('click', function () {
            const barisAwal = bodyJual.querySelector('.baris-jual');
            const barisBaru = barisAwal.cloneNode(true);

            barisBaru.querySelector('.select-barang-jual').selectedIndex = 0;
            barisBaru.querySelector('.input-harga-jual').value           = 'Rp 0';
            barisBaru.querySelector('.input-qty-jual').value             = 1;
            barisBaru.querySelector('.input-qty-jual').removeAttribute('max');
            barisBaru.querySelector('.input-sub-jual').value             = 'Rp 0';

            bodyJual.appendChild(barisBaru);
            kalkulasiNota();
        });

        bodyJual.addEventListener('change', function (e) {
            if (e.target.classList.contains('select-barang-jual')) {
                kalkulasiNota();
            }
        });

        bodyJual.addEventListener('input', function (e) {
            if (e.target.classList.contains('input-qty-jual')) {
                kalkulasiNota();
            }
        });

        bodyJual.addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-hapus-jual')) {
                e.target.closest('.baris-jual').remove();
                kalkulasiNota();
            }
        });
    });
    </script>
</body>
</html>