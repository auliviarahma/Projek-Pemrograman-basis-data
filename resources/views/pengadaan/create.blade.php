<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengadaan Baru - SIMBA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #0284c7;
            --primary-blue-hover: #0369a1;
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
            letter-spacing: -0.5px;
            text-decoration: none;
        }

        .main-wrapper {
            max-width: 800px;
            margin: 2.5rem auto;
            padding: 0 1.5rem;
        }

        .card-custom {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 2rem;
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

        .calc-box {
            background-color: #f1f5f9;
            border-radius: 8px;
            padding: 1.25rem;
            border: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>

    <header class="top-navbar">
        <a href="/" class="brand-text">SIMBA</a>
        <span class="text-white small fw-bold">Modul Pengadaan (PO)</span>
    </header>

    <main class="main-wrapper">
        <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div>
                    <h4 class="fw-bold mb-1" style="color: #0f172a;">Buat Pengadaan (PO) Baru</h4>
                    <p class="text-muted small mb-0">Input dokumen Purchase Order untuk pemesanan barang ke vendor</p>
                </div>
                <a href="{{ route('pengadaan.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('pengadaan.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label fw-bold small text-muted">VENDOR / SUPLIER</label>
                        <select name="idvendor" class="form-select" required>
                            <option value="">-- Pilih Vendor --</option>
                            @foreach ($vendors as $v)
                                <option value="{{ $v->idvendor }}" {{ old('idvendor') == $v->idvendor ? 'selected' : '' }}>
                                    {{ $v->nama_vendor }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">DIBUAT OLEH (USER)</label>
                        <select name="iduser" class="form-select" required>
                            <option value="">-- Pilih Petugas / User --</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->iduser }}" {{ old('iduser') == $u->iduser ? 'selected' : '' }}>
                                    {{ $u->username }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">BARANG YANG DIPESAN</label>
                    <select name="idbarang" class="form-select" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($barangs as $b)
                            <option value="{{ $b->idbarang }}" {{ old('idbarang') == $b->idbarang ? 'selected' : '' }}>
                                {{ $b->nama }} (ID: {{ $b->idbarang }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label fw-bold small text-muted">JUMLAH PESANAN</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Contoh: 50" min="1" value="{{ old('jumlah') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">HARGA SATUAN (RP)</label>
                        <input type="number" name="harga_satuan" id="harga_satuan" class="form-control" placeholder="Contoh: 25000" min="0" value="{{ old('harga_satuan') }}" required>
                    </div>
                </div>

                <div class="calc-box mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Subtotal Nilai:</span>
                        <span class="fw-semibold" id="txtSubtotal">Rp0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">PPN (11%):</span>
                        <span class="fw-semibold" id="txtPPN">Rp0</span>
                    </div>
                    <div class="d-flex justify-content-between border-top pt-2">
                        <span class="fw-bold">Total Nilai Pengadaan:</span>
                        <span class="fw-bold text-primary fs-5" id="txtTotal">Rp0</span>
                    </div>
                </div>

                <button type="submit" class="btn btn-blue w-100 py-2">
                    <i class="fa-solid fa-cart-plus me-1"></i> Simpan & Terbitkan PO Pengadaan
                </button>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const inputJumlah = document.getElementById('jumlah');
        const inputHarga = document.getElementById('harga_satuan');
        const txtSubtotal = document.getElementById('txtSubtotal');
        const txtPPN = document.getElementById('txtPPN');
        const txtTotal = document.getElementById('txtTotal');

        function hitungTotal() {
            const jml = parseFloat(inputJumlah.value) || 0;
            const hrg = parseFloat(inputHarga.value) || 0;
            const subtotal = jml * hrg;
            const ppn = Math.round(subtotal * 0.11);
            const total = subtotal + ppn;

            txtSubtotal.innerText = 'Rp' + subtotal.toLocaleString('id-ID');
            txtPPN.innerText = 'Rp' + ppn.toLocaleString('id-ID');
            txtTotal.innerText = 'Rp' + total.toLocaleString('id-ID');
        }

        inputJumlah.addEventListener('input', hitungTotal);
        inputHarga.addEventListener('input', hitungTotal);
    </script>
</body>
</html>