@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Dashboard Admin</h1>
        <span class="text-muted">{{ now()->format('d F Y') }}</span>
    </div>
@stop

@section('content')
    <!-- Statistik Cards -->
    <div class="row">
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalSeniman }}</h3>
                    <p>Total Seniman</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalKarya }}</h3>
                    <p>Total Karya</p>
                </div>
                <div class="icon">
                    <i class="fas fa-palette"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $karyaMenunggu }}</h3>
                    <p>Menunggu Review</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3>{{ $karyaPerluRevisi }}</h3>
                    <p>Perlu Revisi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-edit"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $karyaDipublikasikan }}</h3>
                    <p>Dipublikasikan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $kategoriAktif }}</h3>
                    <p>Kategori</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tags"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Karya Menunggu Review -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning">
                    <h3 class="card-title"><i class="fas fa-clock mr-2"></i> Karya Menunggu Review</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.karya.index', ['status' => 'diajukan']) }}" class="btn btn-sm btn-light">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Karya</th>
                                <th>Seniman</th>
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
                                <td colspan="4" class="text-center">Tidak ada karya yang menunggu review</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Karya Terbaru -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title"><i class="fas fa-palette mr-2"></i> Karya Terbaru</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Karya</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($karyaTerbaru as $karya)
                            <tr>
                                <td>{{ Str::limit($karya->judul_karya, 30) }}</td>
                                <td>
                                    <span class="badge badge-{{ $karya->status_badge_color }}">{{ $karya->status_label }}</span>
                                </td>
                                <td>{{ $karya->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum ada karya</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Dashboard Admin loaded!'); </script>
@stop
