@extends('layouts.admin')

@section('title', 'Dashboard Seniman')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="m-0">Dashboard Seniman</h1>
            <p class="text-muted mb-0">Selamat datang, {{ auth()->user()->nama }}</p>
        </div>
        <a href="{{ route('seniman.karya.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i> Tambah Karya
        </a>
    </div>
@stop

@section('content')
    <!-- Statistik -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $statistik['total'] }}</h3>
                    <p>Total Karya</p>
                </div>
                <div class="icon">
                    <i class="fas fa-palette"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $statistik['draft'] }}</h3>
                    <p>Draft</p>
                </div>
                <div class="icon">
                    <i class="fas fa-edit"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $statistik['diajukan'] }}</h3>
                    <p>Menunggu Review</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $statistik['dipublikasikan'] }}</h3>
                    <p>Dipublikasikan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Karya Terbaru -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Karya Terbaru Saya</h3>
                    <div class="card-tools">
                        <a href="{{ route('seniman.karya.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus mr-1"></i> Tambah Karya
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($karyaTerbaru as $karya)
                            <tr>
                                <td>{{ Str::limit($karya->judul_karya, 40) }}</td>
                                <td>{{ $karya->kategori?->nama_kategori }}</td>
                                <td>
                                    <span class="badge badge-{{ $karya->status_badge_color }}">{{ $karya->status_label }}</span>
                                </td>
                                <td>{{ $karya->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('seniman.karya.edit', $karya) }}" class="btn btn-sm btn-info">Edit</a>
                                    @if($karya->canBeSubmitted())
                                    <form action="{{ route('seniman.karya.ajukan', $karya) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Ajukan karya untuk review?')">Ajukan</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada karya. <a href="{{ route('seniman.karya.create') }}">Tambah karya sekarang</a></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Panduan -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">Panduan</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Tambah karya dengan lengkap</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Upload gambar berkualitas</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Ajukan untuk review</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Tunggu persetujuan admin</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Karya dipublikasikan</li>
                    </ul>
                    <hr>
                    <p class="text-muted mb-0">Status Karya:</p>
                    <ul class="list-unstyled mt-2">
                        <li><span class="badge badge-secondary">Draft</span> - Masih dalam penyusunan</li>
                        <li><span class="badge badge-info">Diajukan</span> - Menunggu review admin</li>
                        <li><span class="badge badge-warning">Perlu Revisi</span> - Perbaiki sesuai catatan</li>
                        <li><span class="badge badge-success">Dipublikasikan</span> - Karya sudah tayang</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
