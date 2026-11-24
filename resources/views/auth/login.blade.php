<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMBA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #bae6fd;
            box-shadow: 0 10px 25px rgba(2, 132, 199, 0.08);
            overflow: hidden;
        }
        .login-header {
            background-color: #0284c7;
            color: #ffffff;
            padding: 1.75rem 1.5rem;
            text-align: center;
        }
        .btn-simba {
            background-color: #0284c7;
            border: none;
            color: #ffffff;
            font-weight: 700;
            padding: 0.65rem;
        }
        .btn-simba:hover {
            background-color: #0369a1;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h3 class="fw-extrabold mb-1" style="font-weight: 800;">SIMBA</h3>
            <p class="small mb-0 opacity-75">Sistem Informasi Manajemen Barang</p>
        </div>

        <div class="p-4">
            @if (session('error'))
                <div class="alert alert-danger small py-2 mb-3">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success small py-2 mb-3">
                    <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold small text-secondary">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-user text-muted"></i></span>
                        <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Masukkan username" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-simba w-100 rounded-3">
                    <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk ke Sistem
                </button>
            </form>
        </div>
    </div>
</body>
</html>