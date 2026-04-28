@extends('layouts.seniman')

@section('title', 'Dashboard Seniman')

@section('content')
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
        <div>
            <h1 class="h4 mb-0 font-display">Dashboard Seniman</h1>
            <p class="text-muted mb-0">Selamat datang, {{ auth()->user()->nama }}</p>
        </div>
        <a href="{{ route('seniman.karya.create') }}" class="btn btn-primary" style="background: var(--primary); border-color: var(--primary); border-radius: var(--radius-sm);">
            <i class="bi bi-plus-circle me-1"></i> Tambah Karya
        </a>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card h-100 border-0" style="border-radius: var(--radius); box-shadow: var(--shadow); background: var(--primary); color: #ffffff; border: none;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="mb-1" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; color: rgba(255,255,255,0.85);">Total Karya</h6>
                            <h3 class="mb-0 font-display fw-bold" style="color: #ffffff;">{{ $statistik['total'] }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded" style="width: 48px; height: 48px; background: rgba(255,255,255,0.2);">
                                <i class="bi bi-palette fs-4" style="color: #ffffff;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-12">
            <div class="card h-100 border-0" style="border-radius: var(--radius); box-shadow: var(--shadow); background: #6c757d; color: #ffffff; border: none;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="mb-1" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; color: rgba(255,255,255,0.85);">Draft</h6>
                            <h3 class="mb-0 font-display fw-bold" style="color: #ffffff;">{{ $statistik['draft'] }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded" style="width: 48px; height: 48px; background: rgba(255,255,255,0.2);">
                                <i class="bi bi-pencil fs-4" style="color: #ffffff;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-12">
            <div class="card h-100 border-0" style="border-radius: var(--radius); box-shadow: var(--shadow); background: #fd7e14; color: #ffffff; border: none;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="mb-1" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; color: rgba(255,255,255,0.85);">Menunggu Review</h6>
                            <h3 class="mb-0 font-display fw-bold" style="color: #ffffff;">{{ $statistik['diajukan'] }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded" style="width: 48px; height: 48px; background: rgba(255,255,255,0.2);">
                                <i class="bi bi-clock fs-4" style="color: #ffffff;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-12">
            <div class="card h-100 border-0" style="border-radius: var(--radius); box-shadow: var(--shadow); background: #198754; color: #ffffff; border: none;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="mb-1" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; color: rgba(255,255,255,0.85);">Dipublikasikan</h6>
                            <h3 class="mb-0 font-display fw-bold" style="color: #ffffff;">{{ $statistik['dipublikasikan'] }}</h3>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex align-items-center justify-content-center rounded" style="width: 48px; height: 48px; background: rgba(255,255,255,0.2);">
                                <i class="bi bi-check-circle fs-4" style="color: #ffffff;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Karya Terbaru -->
        <div class="col-md-8">
            <div class="card border-0 h-100" style="border-radius: var(--radius); box-shadow: var(--shadow);">
                <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom: 1px solid var(--border); padding: 16px 20px;">
                    <h5 class="mb-0 font-display fw-bold" style="font-size: 1.1rem;"><i class="bi bi-card-image me-2" style="color: var(--primary);"></i>Karya Terbaru Saya</h5>
                    <a href="{{ route('seniman.karya.create') }}" class="btn btn-sm btn-primary" style="background: var(--primary); border-color: var(--primary); border-radius: var(--radius-sm);">
                        <i class="bi bi-plus-circle me-1"></i> Tambah
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive-wrapper">
                        <table class="table table-hover mb-0" style="font-size: 0.9rem;">
                            <thead style="background: var(--bg);">
                                <tr>
                                    <th style="padding: 12px 16px; font-weight: 600;">Judul</th>
                                    <th style="padding: 12px 16px; font-weight: 600;">Kategori</th>
                                    <th style="padding: 12px 16px; font-weight: 600;">Status</th>
                                    <th class="d-none d-sm-table-cell" style="padding: 12px 16px; font-weight: 600;">Tanggal</th>
                                    <th style="padding: 12px 16px; font-weight: 600;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($karyaTerbaru as $karya)
                                <tr>
                                    <td style="padding: 12px 16px;">{{ Str::limit($karya->judul_karya, 40) }}</td>
                                    <td style="padding: 12px 16px;">{{ $karya->kategori?->nama_kategori }}</td>
                                    <td style="padding: 12px 16px;">
                                        <span class="badge" style="background: {{ $karya->status_badge_color === 'danger' ? '#fef2f2' : ($karya->status_badge_color === 'success' ? '#ecfdf5' : ($karya->status_badge_color === 'warning' ? '#fffbeb' : '#f1f5f9')) }}; color: {{ $karya->status_badge_color === 'danger' ? '#991b1b' : ($karya->status_badge_color === 'success' ? '#065f46' : ($karya->status_badge_color === 'warning' ? '#92400e' : '#334155')) }}; font-weight: 600;">{{ $karya->status_label }}</span>
                                    </td>
                                    <td class="d-none d-sm-table-cell" style="padding: 12px 16px;">{{ $karya->created_at->format('d/m/Y') }}</td>
                                    <td style="padding: 12px 16px;">
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('seniman.karya.edit', $karya) }}" class="btn btn-sm" style="background: #e0f2fe; color: #0369a1; border: none; border-radius: 6px;"><i class="bi bi-pencil"></i></a>
                                            @if($karya->canBeSubmitted())
                                            <form action="{{ route('seniman.karya.ajukan', $karya) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm" style="background: #ecfdf5; color: #059669; border: none; border-radius: 6px;" onclick="return confirm('Ajukan karya untuk review?')" title="Ajukan Review"><i class="bi bi-send"></i></button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada karya. <a href="{{ route('seniman.karya.create') }}" style="color: var(--primary);">Tambah karya sekarang</a></td>
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
            <div class="card border-0 h-100" style="border-radius: var(--radius); box-shadow: var(--shadow); border-top: 4px solid var(--primary);">
                <div class="card-header bg-white" style="border-bottom: 1px solid var(--border); padding: 16px 20px;">
                    <h5 class="mb-0 font-display fw-bold" style="font-size: 1.1rem; color: var(--primary);"><i class="bi bi-info-circle me-2"></i>Panduan</h5>
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
                        <li class="mb-2"><span class="badge me-2" style="background: #f1f5f9; color: #334155; min-width: 110px; font-weight: 600;">Draft</span> <small class="text-muted">Masih dalam penyusunan</small></li>
                        <li class="mb-2"><span class="badge me-2" style="background: #fffbeb; color: #92400e; min-width: 110px; font-weight: 600;">Diajukan</span> <small class="text-muted">Menunggu review admin</small></li>
                        <li class="mb-2"><span class="badge me-2" style="background: #fef2f2; color: #991b1b; min-width: 110px; font-weight: 600;">Perlu Revisi</span> <small class="text-muted">Perbaiki sesuai catatan</small></li>
                        <li class="mb-2"><span class="badge me-2" style="background: #ecfdf5; color: #065f46; min-width: 110px; font-weight: 600;">Dipublikasikan</span> <small class="text-muted">Karya sudah tayang</small></li>
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
