@extends('layouts.admin')

@section('title', 'Detail Seniman')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.seniman.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row g-3">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body text-center">
                    @if($user->profilSeniman?->foto_profil)
                    <img src="{{ asset('storage/'.$user->profilSeniman->foto_profil) }}" 
                         class="rounded-circle mb-3 border" 
                         style="width: 120px; height: 120px; object-fit: cover;"
                         alt="{{ $user->nama }}">
                    @else
                    <div class="rounded-circle mb-3 bg-secondary d-flex align-items-center justify-content-center mx-auto" style="width: 120px; height: 120px;">
                        <i class="bi bi-person fs-1 text-white"></i>
                    </div>
                    @endif
                    <h5 class="mb-1">{{ $user->nama }}</h5>
                    <p class="text-muted mb-0">{{ $user->profilSeniman?->nama_panggung ?? 'Seniman' }}</p>
                    
                    <hr class="my-3">
                    
                    <div class="text-start">
                        <div class="mb-2">
                            <small class="text-muted d-block"><i class="bi bi-envelope me-1"></i> Email</small>
                            <span>{{ $user->email }}</span>
                        </div>
                        
                        <div class="mb-2">
                            <small class="text-muted d-block"><i class="bi bi-phone me-1"></i> Telepon</small>
                            <span>{{ $user->nomor_hp ?? '-' }}</span>
                        </div>
                        
                        <div class="mb-2">
                            <small class="text-muted d-block"><i class="bi bi-palette me-1"></i> Bidang Seni</small>
                            <span>{{ $user->profilSeniman?->bidang_seni_utama ?? '-' }}</span>
                        </div>
                        
                        <div class="mb-2">
                            <small class="text-muted d-block"><i class="bi bi-geo-alt me-1"></i> Lokasi</small>
                            <span>{{ $user->profilSeniman?->kabupaten_kota ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Account Management -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Kelola Akun</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.seniman.update-status', $user) }}" method="POST" class="mb-3">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label small">Status Akun</label>
                            <select name="status_akun" class="form-select form-select-sm" onchange="this.form.submit()">
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
                        <button type="submit" class="btn btn-warning btn-sm w-100">
                            <i class="bi bi-key me-1"></i> Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Statistics & Works -->
        <div class="col-lg-8">
            <!-- Statistics Cards -->
            <div class="row g-2 mb-3">
                <div class="col-6 col-md-3">
                    <div class="card border-start border-4 border-info h-100">
                        <div class="card-body p-2 text-center">
                            <h4 class="mb-0">{{ $statistik['total_karya'] }}</h4>
                            <small class="text-muted">Total Karya</small>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-start border-4 border-success h-100">
                        <div class="card-body p-2 text-center">
                            <h4 class="mb-0">{{ $statistik['dipublikasikan'] }}</h4>
                            <small class="text-muted">Dipublikasikan</small>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-start border-4 border-warning h-100">
                        <div class="card-body p-2 text-center">
                            <h4 class="mb-0">{{ $statistik['menunggu_review'] }}</h4>
                            <small class="text-muted">Menunggu Review</small>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-start border-4 border-danger h-100">
                        <div class="card-body p-2 text-center">
                            <h4 class="mb-0">{{ $statistik['perlu_revisi'] }}</h4>
                            <small class="text-muted">Perlu Revisi</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Works Table -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Karya Seniman</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive-wrapper">
                        <table class="table table-hover table-sm align-middle mb-0">
                            <thead class="table-light">
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
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;">{{ $karya->judul_karya }}</div>
                                    </td>
                                    <td>{{ $karya->kategori?->nama_kategori ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $karya->status_badge_color }} small">{{ $karya->status_label }}</span>
                                    </td>
                                    <td class="small">{{ $karya->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">Belum ada karya</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('styles')
<style>
    .table-responsive-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .table-responsive-wrapper::-webkit-scrollbar {
        height: 6px;
    }
    
    .table-responsive-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .table-responsive-wrapper::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
</style>
@endpush
