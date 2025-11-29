<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - AbsensiQR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background: linear-gradient(135deg,#222, #444); display:flex; align-items:center; justify-content:center; min-height:100vh; }
        .login-container{ background:#fff;padding:36px;border-radius:10px; width:100%; max-width:420px; }
        .btn-login{ background:#0d6efd;color:#fff;border:none;width:100%;padding:10px }
    </style>
</head>
<body>
    <div class="login-container">
        <h3 class="text-center mb-3">Admin Login</h3>

        @if($errors->any())
            <script>Swal.fire('Login Gagal','{{ $errors->first() }}','error');</script>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required placeholder="admin@sekolah.test">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="password">
            </div>
            <div class="mb-3 text-center">
                <button class="btn btn-login">Masuk sebagai Admin</button>
            </div>
        </form>

        <div class="text-center small text-muted">Kembali ke <a href="{{ route('login') }}">Login Siswa/Guru</a></div>
    </div>
</body>
</html>
