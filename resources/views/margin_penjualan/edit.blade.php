<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Margin Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
<div class="container" style="max-width: 500px;">
    <div class="card p-4 shadow-sm border-0 rounded-4">
        <h5 class="fw-bold mb-3">Edit Margin Penjualan</h5>
        <form action="{{ route('margin-penjualan.update', $margin->idmargin_penjualan) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Persentase (%)</label>
                <input type="number" step="0.01" name="persen" class="form-control" value="{{ $margin->persen }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="1" {{ $margin->status == 1 ? 'selected' : '' }}>Aktif (1)</option>
                    <option value="0" {{ $margin->status == 0 ? 'selected' : '' }}>Non-Aktif (0)</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">User Pembuat</label>
                <select name="iduser" class="form-select">
                    <option value="">-- Pilih User --</option>
                    @foreach($user as $u)
                        <option value="{{ $u->iduser }}" {{ $margin->iduser == $u->iduser ? 'selected' : '' }}>
                            {{ $u->username }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('margin-penjualan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
</body>
</html>