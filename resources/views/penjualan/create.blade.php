


<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">Kasir Penjualan (Multi-Barang)</h5>
                <small class="text-muted">Harga jual dihitung otomatis melalui Stored Function <code>hitung_harga_jual()</code></small>
            </div>
            <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary btn-sm rounded-3">Kembali</a>
        </div>
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger rounded-3">
                    <strong>Gagal Transaksi:</strong> {{ session('error') }}
                </div>
            @endif

            @if (!$marginAktif)
                <div class="alert alert-warning rounded-3">
                    <strong>Perhatian!</strong> Belum ada Margin Penjualan yang aktif. Silakan aktifkan salah satu margin di menu <strong>Margin Penjualan</strong> terlebih dahulu sebelum melakukan transaksi.
                </div>
            @endif

            <form action="{{ route('penjualan.store') }}" method="POST">
                @csrf
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kasir / Petugas Pencatat</label>
                        <select name="iduser" class="form-select rounded-3">
                            <option value="">-- Otomatis / Pilih Kasir --</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->iduser }}">{{ $u->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Margin Keuntungan Aktif Saat Ini</label>
                        <input type="text" class="form-control bg-light fw-bold text-success rounded-3" 
                               value="{{ $marginAktif ? $marginAktif->persen . '% (ID Margin #' . $marginAktif->idmargin_penjualan . ')' : 'Tidak Ada Margin Aktif' }}" 
                               readonly>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0">Item Barang Dibeli</h6>
                    <button type="button" id="btn-tambah-item" class="btn btn-primary btn-sm rounded-3">
                        + Tambah Item
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
                                            <option value="{{ $b->idbarang }}" 
                                                    data-harga="{{ round($b->harga_jual) }}" 
                                                    data-stok="{{ $b->stok_tersedia }}">
                                                {{ $b->nama_barang }} (Stok: {{ $b->stok_tersedia }})
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

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success px-4 rounded-3" {{ !$marginAktif ? 'disabled' : '' }}>
                        Proses & Selesaikan Penjualan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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
            const select = row.querySelector('.select-barang-jual');
            const opt    = select.options[select.selectedIndex];
            const harga  = Number(opt?.dataset.harga || 0);
            const qty    = Number(row.querySelector('.input-qty-jual').value || 0);
            const sub    = harga * qty;

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
