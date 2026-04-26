<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portal Karya Seniman Sumbawa</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0f766e;
            --primary-dark: #134e4a;
            --primary-light: #f0fdfa;
            --accent: #d97706;
        }

        body {
            background: linear-gradient(135deg, #134e4a 0%, #0f766e 50%, #115e59 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            padding: 20px;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            padding: 48px 40px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .login-logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-logo h3 {
            color: var(--primary-dark);
            font-weight: 700;
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.75rem;
        }

        .login-logo p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-top: 4px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: #334155;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 16px;
            border: 1.5px solid #e2e8f0;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.1);
        }

        .btn-login {
            background: var(--primary);
            border: none;
            width: 100%;
            padding: 14px;
            font-weight: 700;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.2s;
            letter-spacing: 0.3px;
        }

        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 10px 20px -5px rgba(15, 118, 110, 0.3);
        }

        .register-link {
            text-align: center;
            margin-top: 24px;
            font-size: 0.9rem;
        }

        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <h3>Portal Karya Seniman</h3>
            <p class="text-muted">Sumbawa Besar</p>
        </div>

        @if($errors->any())
        <div class="alert alert-danger border-0" style="background: #fef2f2; color: #991b1b; border-radius: 10px;">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success border-0" style="background: #ecfdf5; color: #065f46; border-radius: 10px;">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       id="password" name="password" required placeholder="••••••••">
            </div>

            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember" style="font-size: 0.875rem; color: #64748b;">Ingat Saya</label>
            </div>

            <button type="submit" class="btn btn-login btn-primary">Masuk</button>
        </form>

        <div class="register-link">
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai Seniman</a></p>
            <p class="mt-3"><a href="{{ route('home') }}">Kembali ke Beranda</a></p>
        </div>
    </div>
</body>
</html>
