<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Seniman - Portal Karya Seniman Sumbawa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #B83B3B 0%, #8B2C2C 100%);
            min-height: 100vh;
            padding: 40px 0;
        }
        .register-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
        .register-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .register-logo h3 {
            color: #B83B3B;
            font-weight: 700;
        }
        .btn-register {
            background: #B83B3B;
            border: none;
            width: 100%;
            padding: 12px;
            font-weight: 600;
        }
        .btn-register:hover {
            background: #8B2C2C;
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
        <div class="alert alert-danger">
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
                <input type="text" class="form-control" id="bidang_seni_utama" name="bidang_seni_utama" 
                       value="{{ old('bidang_seni_utama') }}" required 
                       placeholder="Contoh: Tari, Musik, Kriya, Lukis, dll">
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
            <p>Sudah punya akun? <a href="{{ route('login') }}" class="text-danger">Masuk di sini</a></p>
            <p class="mt-2"><a href="{{ route('home') }}">Kembali ke Beranda</a></p>
        </div>
    </div>
</body>
</html>
