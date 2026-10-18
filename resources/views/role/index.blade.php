<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Role</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f1f5f9; font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        .nav-card { background: white; border-radius: 14px; border: 1px solid #e2e8f0; }
        .nav-link-custom { color: #64748b; font-weight: 500; padding: 8px 14px; border-radius: 8px; text-decoration: none; }
        .nav-link-custom.active { background: #4f46e5; color: white; }
        .main-card { background: white; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .table-custom thead th { background: #f8fafc; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e2e8f0; padding: 12px 16px; }
        .table-custom tbody td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .badge-role-tag { background: #ecfeff; color: #0e7490; border: 1px solid #a5f3fc; border-radius: 6px; padding: 4px 10px; font-weight: 600; font-size: 0.8rem; }
        .btn-indigo { background: #4f46e5; color: white; border-radius: 8px; font-weight: 500; font-size: 0.875rem; }
        .btn-indigo:hover { background: #4338ca; color: white; }
        .btn-action-edit { background: #e0e7ff; color: #3730a3; border-radius: 6px; padding: 5px 10px; font-size: 0.8rem; font-weight: 500; text-decoration: none; }
        .btn-action-edit:hover { background: #c7d2fe; color: #312e81; }
        .btn-action-del { background: #fee2e2; color: #991b1b; border: none; border-radius: 6px; padding: 5px 10px; font-size: 0.8rem; font-weight: 500; }
        .btn-action-del:hover { background: #fecaca; }
    </style>
</head>
<body class="py-4">

<div class="container" style="max-width: 980px;">
    <!-- Menu Tab Navigasi -->
    <div class="nav-card p-2 mb-3 d-flex flex-wrap gap-2">
        <a href="{{ route('dashboard') }}" class="nav-link-custom"><i class="fa-solid fa-house me-1"></i> Beranda</a>
        <a href="{{ route('satuan.index') }}" class="nav-link-custom"><i class="fa-solid fa-ruler me-1"></i> Satuan</a>
        <a href="{{ route('barang.index') }}" class="nav-link-custom"><i class="fa-solid fa-box-open me-1"></i> Barang</a>
        <a href="{{ route('vendor.index') }}" class="nav-link-custom"><i class="fa-solid fa-truck-field me-1"></i> Vendor</a>
        <a href="{{ route('role.index') }}" class="nav-link-custom active"><i class="fa-solid fa-user-shield me-1"></i> Role</a>
        <a href="{{ route('user.index') }}" class="nav-link-custom"><i class="fa-solid fa-users me-1"></i> User</a>
        <a href="{{ route('margin-penjualan.index') }}" class="nav-link-custom"><i class="fa-solid fa-percent me-1"></i> Margin</a>
    </div>

    <div class="main-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-slate-800 m-0">Master Role</h4>
                <small class="text-muted">Kelola hak akses dan tingkatan wewenang pengguna</small>
            </div>
            <a href="{{ route('role.create') }}" class="btn btn-indigo px-3">
                <i class="fa-solid fa-plus me-1"></i> Tambah Role
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2 border-0" style="background: #ecfdf5; color: #047857;">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Nama Wewenang / Role</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($role as $row)
                    <tr>
                        <td class="text-muted fw-bold">#{{ $row->idrole }}</td>
                        <td>
                            <span class="badge-role-tag">
                                <i class="fa-solid fa-shield-halved me-1"></i>{{ $row->nama_role }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('role.edit', $row->idrole) }}" class="btn-action-edit me-1">
                                <i class="fa-solid fa-pen-to-square me-1"></i>Edit
                            </a>
                            <form action="{{ route('role.destroy', $row->idrole) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus role ini?');">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn-action-del">
                                    <i class="fa-solid fa-trash me-1"></i>Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>