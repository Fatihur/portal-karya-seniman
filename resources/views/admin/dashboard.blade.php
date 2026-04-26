@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card h-100 border-0" style="border-radius: var(--radius); box-shadow: var(--shadow); border-left: 4px solid #0ea5e9;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Total Seniman</h6>
                            <h3 class="mb-0 font-display fw-bold">{{ $totalSeniman }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded" style="width: 40px; height: 40px; background: #e0f2fe;">
                                <i class="bi bi-people fs-5" style="color: #0ea5e9;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="card h-100 border-0" style="border-radius: var(--radius); box-shadow: var(--shadow); border-left: 4px solid var(--primary);">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Total Karya</h6>
                            <h3 class="mb-0 font-display fw-bold">{{ $totalKarya }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded" style="width: 40px; height: 40px; background: var(--primary-light);">
                                <i class="bi bi-palette fs-5" style="color: var(--primary);"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="card h-100 border-0" style="border-radius: var(--radius); box-shadow: var(--shadow); border-left: 4px solid #d97706;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Menunggu Review</h6>
                            <h3 class="mb-0 font-display fw-bold">{{ $karyaMenunggu }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded" style="width: 40px; height: 40px; background: #fffbeb;">
                                <i class="bi bi-clock fs-5" style="color: #d97706;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="card h-100 border-0" style="border-radius: var(--radius); box-shadow: var(--shadow); border-left: 4px solid #64748b;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Perlu Revisi</h6>
                            <h3 class="mb-0 font-display fw-bold">{{ $karyaPerluRevisi }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded" style="width: 40px; height: 40px; background: #f1f5f9;">
                                <i class="bi bi-pencil fs-5" style="color: #64748b;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="card h-100 border-0" style="border-radius: var(--radius); box-shadow: var(--shadow); border-left: 4px solid #059669;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Dipublikasikan</h6>
                            <h3 class="mb-0 font-display fw-bold">{{ $karyaDipublikasikan }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded" style="width: 40px; height: 40px; background: #ecfdf5;">
                                <i class="bi bi-check-circle fs-5" style="color: #059669;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="card h-100 border-0" style="border-radius: var(--radius); box-shadow: var(--shadow); border-left: 4px solid #7c3aed;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Kategori</h6>
                            <h3 class="mb-0 font-display fw-bold">{{ $kategoriAktif }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded" style="width: 40px; height: 40px; background: #ede9fe;">
                                <i class="bi bi-tags fs-5" style="color: #7c3aed;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Karya Menunggu Review -->
        <div class="col-md-6">
            <div class="card border-0 h-100" style="border-radius: var(--radius); box-shadow: var(--shadow);">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: #fffbeb; border-bottom: 1px solid #fde68a; color: #92400e; padding: 16px 20px;">
                    <h5 class="mb-0 font-display fw-bold" style="font-size: 1.05rem;"><i class="bi bi-clock me-2"></i> Karya Menunggu Review</h5>
                    <a href="{{ route('admin.karya.index', ['status' => 'diajukan']) }}" class="btn btn-sm" style="background: #fff; color: #92400e; border: 1px solid #fde68a; border-radius: var(--radius-sm);">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive-wrapper">
                        <table class="table table-hover mb-0" style="font-size: 0.9rem;">
                            <thead style="background: var(--bg);">
                                <tr>
                                    <th style="padding: 12px 16px; font-weight: 600;">Karya</th>
                                    <th class="d-none d-md-table-cell" style="padding: 12px 16px; font-weight: 600;">Seniman</th>
                                    <th style="padding: 12px 16px; font-weight: 600;">Tanggal</th>
                                    <th style="padding: 12px 16px; font-weight: 600;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($menungguReview as $karya)
                                <tr>
                                    <td style="padding: 12px 16px;">{{ Str::limit($karya->judul_karya, 30) }}</td>
                                    <td class="d-none d-md-table-cell" style="padding: 12px 16px;">{{ $karya->user?->nama }}</td>
                                    <td style="padding: 12px 16px;">{{ $karya->diajukan_pada?->format('d/m/Y') }}</td>
                                    <td style="padding: 12px 16px;">
                                        <a href="{{ route('admin.karya.review', $karya) }}" class="btn btn-sm" style="background: var(--primary); color: white; border-radius: var(--radius-sm); font-weight: 600;">Review</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">Tidak ada karya yang menunggu review</td>
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
            <div class="card border-0 h-100" style="border-radius: var(--radius); box-shadow: var(--shadow);">
                <div class="card-header" style="background: #e0f2fe; border-bottom: 1px solid #bae6fd; color: #075985; padding: 16px 20px;">
                    <h5 class="mb-0 font-display fw-bold" style="font-size: 1.05rem;"><i class="bi bi-palette me-2"></i> Karya Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive-wrapper">
                        <table class="table table-hover mb-0" style="font-size: 0.9rem;">
                            <thead style="background: var(--bg);">
                                <tr>
                                    <th style="padding: 12px 16px; font-weight: 600;">Karya</th>
                                    <th style="padding: 12px 16px; font-weight: 600;">Status</th>
                                    <th class="d-none d-sm-table-cell" style="padding: 12px 16px; font-weight: 600;">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($karyaTerbaru as $karya)
                                <tr>
                                    <td style="padding: 12px 16px;">{{ Str::limit($karya->judul_karya, 30) }}</td>
                                    <td style="padding: 12px 16px;">
                                        <span class="badge" style="background: {{ $karya->status_badge_color === 'danger' ? '#fef2f2' : ($karya->status_badge_color === 'success' ? '#ecfdf5' : ($karya->status_badge_color === 'warning' ? '#fffbeb' : '#f1f5f9')) }}; color: {{ $karya->status_badge_color === 'danger' ? '#991b1b' : ($karya->status_badge_color === 'success' ? '#065f46' : ($karya->status_badge_color === 'warning' ? '#92400e' : '#334155')) }}; font-weight: 600;">{{ $karya->status_label }}</span>
                                    </td>
                                    <td class="d-none d-sm-table-cell" style="padding: 12px 16px;">{{ $karya->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-3 text-muted">Belum ada karya</td>
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
        border-left: 4px solid var(--primary);
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
        background: #cbd5e1;
        border-radius: 3px;
    }
</style>
@endpush
