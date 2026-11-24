@extends('layouts.simba')

@section('title', 'Detail Penerimaan #' . $penerimaan->idpenerimaan . ' - SIMBA')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.5px;">Detail Penerimaan #{{ $penerimaan->idpenerimaan }}</h3>
        <p class="text-secondary small mb-0">Input fisik barang masuk berdasarkan Pengadaan PO #{{ $penerimaan->idpengadaan }}</p>
    </div>
    <a href="/penerimaan" class="btn btn-sm btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Penerimaan
    </a>
</div>

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
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-3 p-4 h-100">
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
                    <td><span class="badge bg-light text-dark border">{{ $penerimaan->username ?? 'admin' }}</span></td>
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

            <div class="d-flex flex-column gap-2 mt-auto">
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

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Tambah Detail</h5>
            <form action="{{ route('penerimaan.detail.store', $penerimaan->idpenerimaan) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih Barang (Khusus PO #{{ $penerimaan->idpengadaan }})</label>
                    <select name="idbarang" id="select_barang_po" class="form-select" onchange="isiOtomatisPO()" required>
                        <option value="" data-harga="" data-sisa="">-- Pilih Barang dari PO --</option>
                        @forelse ($barangsPO as $b)
                            <option value="{{ $b->idbarang }}"
                                    data-harga="{{ $b->harga_satuan ?? $b->harga ?? '' }}"
                                    data-sisa="{{ $b->sisa_kuota }}"
                                    {{ $b->sisa_kuota == 0 ? 'disabled' : '' }}>
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
                        <input type="number" name="jumlah_terima" id="input_jumlah_terima" class="form-control" placeholder="Contoh: 10" min="1" required>
                        <div class="form-text text-muted small" id="teks_sisa_kuota">Pilih barang untuk melihat batas sisa kuota.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Harga Satuan Terima (Rp)</label>
                        <input type="number" name="harga_satuan_terima" id="input_harga_terima" class="form-control" placeholder="Otomatis terisi saat pilih barang" min="0" required>
                        <div class="form-text text-muted small">Otomatis dari PO; ubah jika ada kenaikan/penurunan harga.</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="background-color: #0284c7; border-color: #0284c7;">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Barang ke Detail Penerimaan
                </button>
            </form>
        </div>

        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="p-3 bg-light border-bottom">
                <h6 class="fw-bold mb-0">Daftar Detail</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #0284c7; color: #ffffff;">
                        <tr>
                            <th class="ps-3 py-2">ID</th>
                            <th class="py-2">BARANG</th>
                            <th class="text-end py-2">JUMLAH</th>
                            <th class="text-end py-2">HARGA</th>
                            <th class="text-end py-2">SUBTOTAL</th>
                            <th class="text-center pe-3 py-2">AKSI</th>
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

<script>
function isiOtomatisPO() {
    const select = document.getElementById('select_barang_po');
    const option = select.options[select.selectedIndex];

    const harga = option.getAttribute('data-harga');
    const sisa  = option.getAttribute('data-sisa');

    const inputHarga  = document.getElementById('input_harga_terima');
    const inputJumlah = document.getElementById('input_jumlah_terima');
    const teksSisa    = document.getElementById('teks_sisa_kuota');

    inputHarga.value = harga ? harga : '';

    if (sisa && parseInt(sisa) > 0) {
        inputJumlah.max = sisa;
        inputJumlah.value = sisa;
        teksSisa.textContent = 'Maksimal sisa pesanan: ' + sisa + ' unit.';
    } else {
        inputJumlah.removeAttribute('max');
        inputJumlah.value = '';
        teksSisa.textContent = 'Pilih barang untuk melihat batas sisa kuota.';
    }
}
</script>
@endsection