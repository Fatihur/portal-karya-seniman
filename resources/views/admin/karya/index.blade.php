@extends('layouts.admin')

@section('title', 'Manajemen Karya Seni')

@section('content')
    <!-- Status Filter Cards -->
    <div class="row g-3 mb-4">
        <div class="col-lg-2 col-md-4 col-6">
            <a href="{{ route('admin.karya.index') }}" class="text-decoration-none">
                <div class="card" style="background: #0d6efd; color: #ffffff; border: none;">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-palette fs-2" style="color: #ffffff;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0" style="color: rgba(255,255,255,0.85);">Total</h6>
                            <h5 class="mb-0" style="color: #ffffff;">{{ $statusCounts['total'] }}</h5>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-lg-2 col-md-4 col-6">
            <a href="{{ route('admin.karya.index', ['status' => 'diajukan']) }}" class="text-decoration-none">
                <div class="card" style="background: #ffc107; color: #ffffff; border: none;">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-clock fs-2" style="color: #ffffff;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0" style="color: rgba(255,255,255,0.85);">Menunggu</h6>
                            <h5 class="mb-0" style="color: #ffffff;">{{ $statusCounts['diajukan'] }}</h5>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-lg-2 col-md-4 col-6">
            <a href="{{ route('admin.karya.index', ['status' => 'perlu_revisi']) }}" class="text-decoration-none">
                <div class="card" style="background: #6f42c1; color: #ffffff; border: none;">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-pencil fs-2" style="color: #ffffff;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0" style="color: rgba(255,255,255,0.85);">Revisi</h6>
                            <h5 class="mb-0" style="color: #ffffff;">{{ $statusCounts['perlu_revisi'] }}</h5>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-lg-2 col-md-4 col-6">
            <a href="{{ route('admin.karya.index', ['status' => 'dipublikasikan']) }}" class="text-decoration-none">
                <div class="card" style="background: #198754; color: #ffffff; border: none;">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-check-circle fs-2" style="color: #ffffff;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0" style="color: rgba(255,255,255,0.85);">Publikasi</h6>
                            <h5 class="mb-0" style="color: #ffffff;">{{ $statusCounts['dipublikasikan'] }}</h5>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-lg-2 col-md-4 col-6">
            <a href="{{ route('admin.karya.index', ['status' => 'ditolak']) }}" class="text-decoration-none">
                <div class="card" style="background: #dc3545; color: #ffffff; border: none;">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="bi bi-x-circle fs-2" style="color: #ffffff;"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0" style="color: rgba(255,255,255,0.85);">Ditolak</h6>
                            <h5 class="mb-0" style="color: #ffffff;">{{ $statusCounts['ditolak'] }}</h5>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Karya Seni</h5>
            <div class="d-flex gap-2">
                <form action="{{ route('admin.karya.index') }}" method="GET" class="d-flex">
                    <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari karya..." value="{{ request('q') }}" style="width: 250px;">
                    <button type="submit" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <a href="{{ route('admin.karya.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise"></i> Refresh
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive-wrapper">
                <table class="table table-hover table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 80px;">Thumbnail</th>
                            <th>Judul</th>
                            <th class="d-none d-md-table-cell">Seniman</th>
                            <th class="d-none d-lg-table-cell">Kategori</th>
                            <th>Status</th>
                            <th class="d-none d-sm-table-cell">Tanggal</th>
                            <th style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($karyaList as $index => $karya)
                        <tr>
                            <td>{{ $karyaList->firstItem() + $index }}</td>
                            <td>
                                @if($karya->thumbnail_url)
                                <img src="{{ $karya->thumbnail_url }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $karya->judul_karya }}">
                                @else
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" style="width: 50px; height: 50px;">
                                    <i class="bi bi-image"></i>
                                </div>
                                @endif
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 150px;">{{ Str::limit($karya->judul_karya, 30) }}</div>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $karya->user?->nama ?? '-' }}</td>
                            <td class="d-none d-lg-table-cell">{{ $karya->kategori?->nama_kategori ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $karya->status_badge_color }} small">{{ $karya->status_label }}</span>
                            </td>
                            <td class="d-none d-sm-table-cell small">{{ $karya->diajukan_pada?->format('d/m/Y') ?? '-' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.karya.show', $karya) }}" class="btn btn-outline-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($karya->status_karya->value == 'diajukan')
                                    <a href="{{ route('admin.karya.review', $karya) }}" class="btn btn-outline-primary" title="Review">
                                        <i class="bi bi-journal-check"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Belum ada karya</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($karyaList->hasPages())
        <div class="card-footer">
            {{ $karyaList->withQueryString()->links() }}
        </div>
        @endif
    </div>
@stop

@push('styles')
<style>
    .table-responsive-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .table-responsive-wrapper table {
        min-width: 600px;
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
