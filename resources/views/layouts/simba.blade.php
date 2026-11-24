<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMBA')</title>

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
            text-decoration: none;
        }

        .sidebar {
            width: 230px;
            min-height: calc(100vh - 60px);
            background-color: #ffffff;
            border-right: 1px solid #f0f0f0;
            padding-top: 1.5rem;
            flex-shrink: 0;
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

        .accordion-btn-custom:hover, .accordion-btn-custom.active-parent {
            color: var(--primary-blue);
            font-weight: 800;
        }

        .sub-link {
            display: block;
            padding: 6px 1.5rem 6px 3rem;
            color: #777777;
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .sub-link:hover, .sub-link.active {
            color: var(--primary-blue);
            font-weight: 800;
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

        .card-table {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            overflow: hidden;
        }

        .table thead th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: 700;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 16px;
        }

        .table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    @php
        $currentUser = \Illuminate\Support\Facades\Auth::user();
        $currentRole = $currentUser ? \Illuminate\Support\Facades\DB::table('role')->where('idrole', $currentUser->idrole)->value('nama_role') : 'Guest';
        $isSuperAdmin = strtolower(trim($currentRole ?? '')) === 'super admin';
        $isMaster = request()->is('satuan*', 'barang*', 'vendor*', 'role*', 'user*', 'margin-penjualan*');
    @endphp

    <header class="top-navbar">
        <a href="/" class="brand-text">SIMBA</a>
        <div class="text-white d-flex align-items-center gap-3">
            @if ($currentUser)
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-regular fa-user"></i>
                    <span class="small fw-bold">{{ $currentUser->username }}</span>
                    <span class="badge bg-light text-primary fw-bold">{{ $currentRole }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light fw-bold">
                        <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                    </button>
                </form>
            @endif
        </div>
    </header>

    <div class="d-flex">
        <aside class="sidebar">
            <ul class="list-unstyled p-0 m-0">
                <li>
                    <a href="/" class="sidebar-link {{ request()->is('/') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if ($isSuperAdmin)
                    <li>
                        <button class="accordion-btn-custom {{ $isMaster ? 'active-parent' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#anakMasterData" aria-expanded="{{ $isMaster ? 'true' : 'false' }}">
                            <span><i class="fa-regular fa-folder me-2"></i> Master Data</span>
                            <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i>
                        </button>
                        <div class="collapse {{ $isMaster ? 'show' : '' }}" id="anakMasterData">
                            <a href="/satuan" class="sub-link {{ request()->is('satuan*') ? 'active' : '' }}">Master Satuan</a>
                            <a href="/barang" class="sub-link {{ request()->is('barang*') ? 'active' : '' }}">Master Barang</a>
                            <a href="/vendor" class="sub-link {{ request()->is('vendor*') ? 'active' : '' }}">Master Vendor</a>
                            <a href="/role" class="sub-link {{ request()->is('role*') ? 'active' : '' }}">Master Role</a>
                            <a href="/user" class="sub-link {{ request()->is('user*') ? 'active' : '' }}">Master User</a>
                            <a href="/margin-penjualan" class="sub-link {{ request()->is('margin-penjualan*') ? 'active' : '' }}">Margin Penjualan</a>
                        </div>
                    </li>
                @endif

                <li class="menu-heading">TRANSAKSI</li>

                @if ($isSuperAdmin)
                    <li>
                        <a href="/pengadaan" class="sidebar-link {{ request()->is('pengadaan*') ? 'active' : '' }}">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span>Pengadaan</span>
                        </a>
                    </li>
                    <li>
                        <a href="/penerimaan" class="sidebar-link {{ request()->is('penerimaan*') ? 'active' : '' }}">
                            <i class="fa-solid fa-truck-ramp-box"></i>
                            <span>Penerimaan</span>
                        </a>
                    </li>
                @endif

                <li>
                    <a href="/penjualan" class="sidebar-link {{ request()->is('penjualan*') ? 'active' : '' }}">
                        <i class="fa-solid fa-cash-register"></i>
                        <span>Penjualan</span>
                    </a>
                </li>
                <li>
                    <a href="/kartu-stok" class="sidebar-link {{ request()->is('kartu-stok*') ? 'active' : '' }}">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <span>Kartu Stok</span>
                    </a>
                </li>
            </ul>
        </aside>

        <main class="main-wrapper">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>