@extends('layouts.seniman')

@section('title', 'Dashboard Seniman')

@section('content')
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
        <div>
            <h1 class="h4 mb-0">Dashboard Seniman</h1>
            <p class="text-muted mb-0">Selamat datang, {{ auth()->user()->nama }}</p>
        </div>
        <a href="{{ route('seniman.karya.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Karya
        </a>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card stat-card h-100 border-primary border-start border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Total Karya</h6>
                            <h3 class="mb-0">{{ $statistik['total'] }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-palette fs-2 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card stat-card h-100 border-secondary border-start border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Draft</h6>
                            <h3 class="mb-0">{{ $statistik['draft'] }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-pencil fs-2 text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card stat-card h-100 border-warning border-start border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Menunggu Review</h6>
                            <h3 class="mb-0">{{ $statistik['diajukan'] }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-clock fs-2 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card stat-card h-100 border-success border-start border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Dipublikasikan</h6>
                            <h3 class="mb-0">{{ $statistik['dipublikasikan'] }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-check-circle fs-2 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Karya Terbaru -->
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-card-image me-2"></i>Karya Terbaru Saya</h5>
                    <a href="{{ route('seniman.karya.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Tambah
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive-wrapper">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th class="d-none d-sm-table-cell">Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($karyaTerbaru as $karya)
                                <tr>
                                    <td>{{ Str::limit($karya->judul_karya, 40) }}</td>
                                    <td>{{ $karya->kategori?->nama_kategori }}</td>
                                    <td>
                                        <span class="badge bg-{{ $karya->status_badge_color }}">{{ $karya->status_label }}</span>
                                    </td>
                                    <td class="d-none d-sm-table-cell">{{ $karya->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('seniman.karya.edit', $karya) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-pencil"></i></a>
                                            @if($karya->canBeSubmitted())
                                            <form action="{{ route('seniman.karya.ajukan', $karya) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Ajukan karya untuk review?')" title="Ajukan Review"><i class="bi bi-send"></i></button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Belum ada karya. <a href="{{ route('seniman.karya.create') }}">Tambah karya sekarang</a></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Panduan -->
        <div class="col-md-4">
            <div class="card h-100 border-info border-top border-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0 text-info"><i class="bi bi-info-circle me-2"></i>Panduan</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2 fw-bold"></i> Tambah karya dengan lengkap</li>
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2 fw-bold"></i> Upload gambar berkualitas</li>
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2 fw-bold"></i> Ajukan untuk review</li>
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2 fw-bold"></i> Tunggu persetujuan admin</li>
                        <li class="mb-2"><i class="bi bi-check2 text-success me-2 fw-bold"></i> Karya dipublikasikan</li>
                    </ul>
                    
                    <h6 class="text-muted border-bottom pb-2">Status Karya:</h6>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2"><span class="badge bg-secondary me-2" style="width: 100px;">Draft</span> <small class="text-muted">Masih dalam penyusunan</small></li>
                        <li class="mb-2"><span class="badge bg-warning text-dark me-2" style="width: 100px;">Diajukan</span> <small class="text-muted">Menunggu review admin</small></li>
                        <li class="mb-2"><span class="badge bg-secondary me-2" style="width: 100px;">Perlu Revisi</span> <small class="text-muted">Perbaiki sesuai catatan</small></li>
                        <li class="mb-2"><span class="badge bg-success me-2" style="width: 100px;">Dipublikasikan</span> <small class="text-muted">Karya sudah tayang</small></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop

@push('styles')
<style>
    .stat-card {
        transition: transform 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
    }
    
    .table-responsive-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
</style>
@endpush
