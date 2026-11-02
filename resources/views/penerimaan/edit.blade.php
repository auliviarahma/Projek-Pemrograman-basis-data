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
            text-decoration: none;
        }

        .main-wrapper {
            max-width: 650px;
            margin: 3rem auto;
            padding: 0 1rem;
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
        }

        .btn-blue:hover {
            background-color: var(--primary-blue-hover);
            color: #ffffff;
        }
    </style>
</head>
<body>

    <header class="top-navbar">
        <a href="/" class="brand-text">SIMBA</a>
        <span class="text-white small fw-bold">Edit Header Transaksi</span>
    </header>

    <main class="main-wrapper">
        <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <h4 class="fw-bold mb-0">Edit Penerimaan #{{ $penerimaan->idpenerimaan }}</h4>
                <a href="{{ route('penerimaan.detail', $penerimaan->idpenerimaan) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Batal
                </a>
            </div>

            <form action="{{ route('penerimaan.update', $penerimaan->idpenerimaan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">PO Pengadaan</label>
                    <select name="idpengadaan" class="form-select" required>
                        @foreach ($pengadaans as $po)
                            <option value="{{ $po->idpengadaan }}" {{ $penerimaan->idpengadaan == $po->idpengadaan ? 'selected' : '' }}>
                                PO #{{ $po->idpengadaan }} - {{ $po->nama_vendor ?? 'Vendor #' . $po->vendor_idvendor }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Petugas Penerima (User)</label>
                    <select name="iduser" class="form-select" required>
                        @foreach ($users as $u)
                            <option value="{{ $u->iduser }}" {{ $penerimaan->iduser == $u->iduser ? 'selected' : '' }}>
                                {{ $u->username }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Status Transaksi</label>
                    <select name="status" class="form-select" required>
                        <option value="F" {{ $penerimaan->status == 'F' ? 'selected' : '' }}>F (Final / Selesai)</option>
                        <option value="1" {{ $penerimaan->status == '1' ? 'selected' : '' }}>1 (Aktif / Proses)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-blue w-100 py-2">
                    <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan Header
                </button>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>