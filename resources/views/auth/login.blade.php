<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AbsensiQR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        /* Animated Background Shapes */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -250px;
            left: -250px;
            animation: float 20s infinite ease-in-out;
        }
        
        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -200px;
            right: -200px;
            animation: float 15s infinite ease-in-out reverse;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(50px, 50px) rotate(90deg); }
            50% { transform: translate(100px, 0) rotate(180deg); }
            75% { transform: translate(50px, -50px) rotate(270deg); }
        }
        
        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1100px;
            display: flex;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        /* Left Panel - Branding */
        .login-brand {
            flex: 1;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .login-brand::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }
        
        .login-brand::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }
        
        .brand-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }
        
        .brand-icon {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .brand-icon i {
            font-size: 60px;
            color: white;
        }
        
        .brand-content h1 {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 15px;
            letter-spacing: -1px;
        }
        
        .brand-content p {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 40px;
            line-height: 1.6;
        }
        
        .features {
            text-align: left;
            width: 100%;
            max-width: 350px;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }
        
        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .feature-icon i {
            font-size: 18px;
        }
        
        .feature-text h6 {
            font-size: 14px;
            font-weight: 600;
            margin: 0 0 4px 0;
        }
        
        .feature-text p {
            font-size: 12px;
            margin: 0;
            opacity: 0.8;
        }
        
        /* Right Panel - Login Form */
        .login-form-container {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-header {
            margin-bottom: 40px;
        }
        
        .login-header h2 {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }
        
        .login-header p {
            color: #64748b;
            font-size: 15px;
        }
        
        /* Role Selector */
        .role-selector {
            margin-bottom: 30px;
            display: flex;
            gap: 12px;
        }
        
        .role-card {
            flex: 1;
            padding: 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }
        
        .role-card:hover {
            border-color: #cbd5e1;
            transform: translateY(-2px);
        }
        
        .role-card.active {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        }
        
        .role-card i {
            font-size: 32px;
            margin-bottom: 12px;
            display: block;
            color: #64748b;
            transition: all 0.3s ease;
        }
        
        .role-card.active i {
            color: #667eea;
        }
        
        .role-card span {
            font-size: 14px;
            font-weight: 600;
            color: #475569;
        }
        
        .role-card.active span {
            color: #667eea;
        }
        
        /* Form Styling */
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 10px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-label i {
            color: #667eea;
            font-size: 16px;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 18px;
        }
        
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px 14px 48px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8fafc;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: white;
            outline: none;
        }
        
        .form-control.is-invalid {
            border-color: #ef4444;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .error-message i {
            font-size: 14px;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .form-check-input {
            width: 20px;
            height: 20px;
            border: 2px solid #cbd5e1;
            border-radius: 6px;
            cursor: pointer;
        }
        
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        .form-check-label {
            font-size: 14px;
            color: #475569;
            cursor: pointer;
            user-select: none;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        /* Demo Credentials */
        .demo-credentials {
            margin-top: 32px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        
        .demo-credentials h6 {
            font-size: 13px;
            font-weight: 700;
            color: #475569;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .demo-item {
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 8px;
            background: white;
            border-radius: 8px;
            font-size: 13px;
        }
        
        .demo-item:last-child {
            margin-bottom: 0;
        }
        
        .demo-item strong {
            color: #334155;
            min-width: 80px;
        }
        
        .demo-item span {
            color: #64748b;
        }
        
        .admin-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .admin-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        .admin-link a:hover {
            color: #764ba2;
            gap: 12px;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .login-brand {
                display: none;
            }
            
            .login-wrapper {
                max-width: 500px;
            }
        }
        
        @media (max-width: 576px) {
            .login-form-container {
                padding: 40px 30px;
            }
            
            .login-header h2 {
                font-size: 26px;
            }
            
            .role-selector {
                flex-direction: column;
            }
            
            .role-card {
                padding: 16px;
            }
            
            .role-card i {
                font-size: 28px;
            }
        }
        
        /* Loading Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-wrapper {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Left Panel - Branding -->
        <div class="login-brand">
            <div class="brand-content">
                <div class="brand-icon">
                    <i class="fas fa-qrcode"></i>
                </div>
                <h1>AbsensiQR</h1>
                <p>Sistem Absensi Modern dengan Teknologi QR Code untuk Efisiensi Maksimal</p>
                
                <div class="features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="feature-text">
                            <h6>Cepat & Efisien</h6>
                            <p>Absensi hanya dalam hitungan detik</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-text">
                            <h6>Aman & Terpercaya</h6>
                            <p>Data terenkripsi dengan baik</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="feature-text">
                            <h6>Laporan Real-time</h6>
                            <p>Pantau kehadiran secara langsung</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Login Form -->
        <div class="login-form-container">
            <div class="login-header">
                <h2>Selamat Datang!</h2>
                <p>Silakan masuk ke akun Anda untuk melanjutkan</p>
            </div>

            @if($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal',
                        text: '{{ $errors->first() }}',
                        confirmButtonColor: '#667eea'
                    });
                </script>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                @unless(request()->query('admin'))
                <!-- Role Selector -->
                <div class="role-selector">
                    <div class="role-card active" data-role="siswa">
                        <i class="fas fa-user-graduate"></i>
                        <span>Siswa</span>
                    </div>
                    <div class="role-card" data-role="guru">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Guru</span>
                    </div>
                </div>
                <input type="hidden" id="selected_role" name="selected_role" value="siswa">
                @endunless

                <!-- Email Input -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-envelope"></i>
                        Email
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-at input-icon"></i>
                        <input type="email" name="email" id="emailInput" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               placeholder="Masukkan alamat email Anda">
                    </div>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i>
                        Password
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-key input-icon"></i>
                        <input type="password" name="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               required 
                               placeholder="Masukkan password Anda">
                    </div>
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label class="form-check-label" for="remember">
                            Ingat saya di perangkat ini
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Masuk Sekarang
                </button>
            </form>


            <!-- Admin Link -->
            <div class="admin-link">
                <a href="/admin">
                    <i class="fas fa-user-shield"></i>
                    Masuk sebagai Admin
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Only enable selector behavior when not in admin mode
        if (!location.search.includes('admin=1')) {
            document.querySelectorAll('.role-card').forEach(card => {
                card.addEventListener('click', function() {
                    // Remove active class from all cards
                    document.querySelectorAll('.role-card').forEach(c => c.classList.remove('active'));
                    
                    // Add active class to clicked card
                    this.classList.add('active');
                    
                    const role = this.dataset.role;
                    const el = document.getElementById('selected_role');
                    if (el) el.value = role;
                    
                    // Update placeholder and demo hints
                    const emailInput = document.getElementById('emailInput');
                    const demoGuru = document.querySelector('.demo-guru');
                    const demoSiswa = document.querySelector('.demo-siswa');
                    
                    if (role === 'guru') {
                        emailInput.placeholder = 'Contoh: budisantoso@guru.absenqr.local';
                        if (demoGuru) demoGuru.style.display = 'flex';
                        if (demoSiswa) demoSiswa.style.display = 'none';
                    } else {
                        emailInput.placeholder = 'Contoh: 2025{NIS}@student.absenqr.local';
                        if (demoGuru) demoGuru.style.display = 'none';
                        if (demoSiswa) demoSiswa.style.display = 'flex';
                    }
                });
            });
            
            // Initialize visibility
            const demoGuru = document.querySelector('.demo-guru');
            const demoSiswa = document.querySelector('.demo-siswa');
            if (demoGuru) demoGuru.style.display = 'none';
            if (demoSiswa) demoSiswa.style.display = 'flex';
        } else {
            // Admin mode: hide demo for siswa/guru
            const demoGuru = document.querySelector('.demo-guru');
            const demoSiswa = document.querySelector('.demo-siswa');
            if (demoGuru) demoGuru.style.display = 'none';
            if (demoSiswa) demoSiswa.style.display = 'none';
        }
    </script>
</body>
</html>