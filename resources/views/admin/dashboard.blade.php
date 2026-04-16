@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Total Seniman</h6>
                            <h3 class="mb-0">{{ $totalSeniman }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-people fs-2 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Total Karya</h6>
                            <h3 class="mb-0">{{ $totalKarya }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-palette fs-2 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Menunggu Review</h6>
                            <h3 class="mb-0">{{ $karyaMenunggu }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-clock fs-2 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Perlu Revisi</h6>
                            <h3 class="mb-0">{{ $karyaPerluRevisi }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-pencil fs-2 text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Dipublikasikan</h6>
                            <h3 class="mb-0">{{ $karyaDipublikasikan }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-check-circle fs-2 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Kategori</h6>
                            <h3 class="mb-0">{{ $kategoriAktif }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="bi bi-tags fs-2 text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Karya Menunggu Review -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-clock me-2"></i> Karya Menunggu Review</h5>
                    <a href="{{ route('admin.karya.index', ['status' => 'diajukan']) }}" class="btn btn-sm btn-light">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive-wrapper">
                        <table class="table table-hover table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Karya</th>
                                    <th class="d-none d-md-table-cell">Seniman</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($menungguReview as $karya)
                                <tr>
                                    <td>{{ Str::limit($karya->judul_karya, 30) }}</td>
                                    <td>{{ $karya->user?->nama }}</td>
                                    <td>{{ $karya->diajukan_pada?->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.karya.review', $karya) }}" class="btn btn-sm btn-primary">Review</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3">Tidak ada karya yang menunggu review</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Karya Terbaru -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-palette me-2"></i> Karya Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive-wrapper">
                        <table class="table table-hover table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Karya</th>
                                    <th>Status</th>
                                    <th class="d-none d-sm-table-cell">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($karyaTerbaru as $karya)
                                <tr>
                                    <td>{{ Str::limit($karya->judul_karya, 30) }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($karya->status) {
                                                'dipublikasikan' => 'bg-success',
                                                'diajukan' => 'bg-warning text-dark',
                                                'direvisi' => 'bg-secondary',
                                                'ditolak' => 'bg-danger',
                                                default => 'bg-light text-dark'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $karya->status_label }}</span>
                                    </td>
                                    <td>{{ $karya->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-3">Belum ada karya</td>
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
    .stat-card {
        border-left: 4px solid var(--sumbawa-red);
        transition: transform 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
    }
    
    .table-responsive-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .table-responsive-wrapper table {
        min-width: 500px;
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
