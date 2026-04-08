@extends('layouts.admin')

@section('title', 'Detail Seniman')

@section('content_header')
    <h1>Detail Seniman</h1>
    <a href="{{ route('admin.seniman.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($user->profilSeniman?->foto_profil)
                    <img src="{{ asset('storage/'.$user->profilSeniman->foto_profil) }}" 
                         class="img-circle elevation-2 mb-3" 
                         style="width: 120px; height: 120px; object-fit: cover;"
                         alt="{{ $user->nama }}">
                    @else
                    <div class="img-circle elevation-2 mb-3 bg-secondary d-flex align-items-center justify-content-center mx-auto" style="width: 120px; height: 120px;">
                        <i class="fas fa-user fa-3x text-white"></i>
                    </div>
                    @endif
                    <h3 class="profile-username text-center">{{ $user->nama }}</h3>
                    <p class="text-muted text-center">{{ $user->profilSeniman?->nama_panggung ?? 'Seniman' }}</p>
                    
                    <hr>
                    
                    <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                    <p class="text-muted">{{ $user->email }}</p>
                    
                    <strong><i class="fas fa-phone mr-1"></i> Telepon</strong>
                    <p class="text-muted">{{ $user->nomor_hp ?? '-' }}</p>
                    
                    <strong><i class="fas fa-paint-brush mr-1"></i> Bidang Seni</strong>
                    <p class="text-muted">{{ $user->profilSeniman?->bidang_seni_utama ?? '-' }}</p>
                    
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Lokasi</strong>
                    <p class="text-muted">{{ $user->profilSeniman?->kabupaten_kota ?? '-' }}</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kelola Akun</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.seniman.update-status', $user) }}" method="POST" class="mb-3">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Status Akun</label>
                            <select name="status_akun" class="form-control" onchange="this.form.submit()">
                                <option value="aktif" {{ $user->status_akun == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ $user->status_akun == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                <option value="diblokir" {{ $user->status_akun == 'diblokir' ? 'selected' : '' }}>Diblokir</option>
                            </select>
                        </div>
                    </form>
                    
                    <form action="{{ route('admin.seniman.reset-password', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin mereset password? Password baru akan diset ke: password123')">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="password" value="password123">
                        <button type="submit" class="btn btn-warning btn-block">
                            <i class="fas fa-key mr-1"></i> Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $statistik['total_karya'] }}</h3>
                            <p>Total Karya</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $statistik['dipublikasikan'] }}</h3>
                            <p>Dipublikasikan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $statistik['menunggu_review'] }}</h3>
                            <p>Menunggu Review</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $statistik['perlu_revisi'] }}</h3>
                            <p>Perlu Revisi</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Karya Seniman</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Judul Karya</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->karyaSeni as $karya)
                            <tr>
                                <td>{{ $karya->judul_karya }}</td>
                                <td>{{ $karya->kategori?->nama_kategori }}</td>
                                <td>
                                    <span class="badge badge-{{ $karya->status_badge_color }}">{{ $karya->status_label }}</span>
                                </td>
                                <td>{{ $karya->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada karya</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
