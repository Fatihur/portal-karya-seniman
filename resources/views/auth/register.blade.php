<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Seniman - Portal Karya Seniman Sumbawa</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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
            padding: 40px 0;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .register-card {
            background: white;
            border-radius: 20px;
            padding: 48px 40px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            width: 100%;
            max-width: 640px;
            margin: 0 auto;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .register-logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .register-logo h3 {
            color: var(--primary-dark);
            font-weight: 700;
            font-family: 'Poppins', Georgia, serif;
            font-size: 1.75rem;
        }

        .register-logo p {
            color: #64748b;
            font-size: 0.9rem;
            margin-top: 4px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: #334155;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 16px;
            border: 1.5px solid #e2e8f0;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.1);
        }

        .btn-register {
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

        .btn-register:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 10px 20px -5px rgba(15, 118, 110, 0.3);
        }

        .text-center a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="register-logo">
            <h3>Registrasi Seniman</h3>
            <p class="text-muted">Portal Karya Seniman Sumbawa Besar</p>
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

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap *</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                           value="{{ old('nama_lengkap') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nama_panggung" class="form-label">Nama Panggung</label>
                    <input type="text" class="form-control" id="nama_panggung" name="nama_panggung"
                           value="{{ old('nama_panggung') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="{{ old('email') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nomor_hp" class="form-label">Nomor HP *</label>
                    <input type="text" class="form-control" id="nomor_hp" name="nomor_hp"
                           value="{{ old('nomor_hp') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="bidang_seni_utama" class="form-label">Bidang Seni Utama *</label>
                <select class="form-select" id="bidang_seni_utama" name="bidang_seni_utama" required>
                    <option value="">-- Pilih Bidang Seni --</option>
                    @foreach($kategoriList as $kategori)
                    <option value="{{ $kategori->nama_kategori }}" {{ old('bidang_seni_utama') == $kategori->nama_kategori ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="2">{{ old('alamat') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password *</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <small class="text-muted">Minimal 8 karakter</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password *</label>
                    <input type="password" class="form-control" id="password_confirmation"
                           name="password_confirmation" required>
                </div>
            </div>

            <button type="submit" class="btn btn-register btn-primary">Daftar</button>
        </form>

        <div class="text-center mt-4">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
            <p class="mt-2"><a href="{{ route('home') }}">Kembali ke Beranda</a></p>
        </div>
    </div>
</body>
</html>
