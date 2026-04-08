@extends('layouts.admin')

@section('title', 'Manajemen Karya Seni')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Manajemen Karya Seni</h1>
        <a href="{{ route('admin.karya.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-sync-alt mr-1"></i> Refresh
        </a>
    </div>
@stop

@section('content')
    <!-- Status Counts -->
    <div class="row mb-3">
        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="{{ route('admin.karya.index') }}" class="text-dark">
                <div class="info-box">
                    <span class="info-box-icon bg-secondary"><i class="fas fa-palette"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total</span>
                        <span class="info-box-number">{{ $statusCounts['total'] }}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="{{ route('admin.karya.index', ['status' => 'diajukan']) }}" class="text-dark">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Menunggu</span>
                        <span class="info-box-number">{{ $statusCounts['diajukan'] }}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="{{ route('admin.karya.index', ['status' => 'perlu_revisi']) }}" class="text-dark">
                <div class="info-box">
                    <span class="info-box-icon bg-orange"><i class="fas fa-edit"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Revisi</span>
                        <span class="info-box-number">{{ $statusCounts['perlu_revisi'] }}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="{{ route('admin.karya.index', ['status' => 'dipublikasikan']) }}" class="text-dark">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Publikasi</span>
                        <span class="info-box-number">{{ $statusCounts['dipublikasikan'] }}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="{{ route('admin.karya.index', ['status' => 'ditolak']) }}" class="text-dark">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="fas fa-times"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Ditolak</span>
                        <span class="info-box-number">{{ $statusCounts['ditolak'] }}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="{{ route('admin.karya.index', ['status' => 'draft']) }}" class="text-dark">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-file"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Draft</span>
                        <span class="info-box-number">{{ $statusCounts['draft'] }}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Karya Seni</h3>
            <div class="card-tools">
                <form action="{{ route('admin.karya.index') }}" method="GET" class="input-group input-group-sm" style="width: 300px;">
                    <input type="text" name="q" class="form-control" placeholder="Cari karya..." value="{{ request('q') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Thumbnail</th>
                        <th>Judul Karya</th>
                        <th>Seniman</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal Diajukan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyaList as $index => $karya)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <img src="{{ $karya->thumbnail_url }}" class="img-thumbnail" style="max-height: 50px;" alt="{{ $karya->judul_karya }}">
                        </td>
                        <td>{{ Str::limit($karya->judul_karya, 40) }}</td>
                        <td>{{ $karya->user?->nama }}</td>
                        <td>{{ $karya->kategori?->nama_kategori }}</td>
                        <td>
                            <span class="badge badge-{{ $karya->status_badge_color }}">{{ $karya->status_label }}</span>
                        </td>
                        <td>{{ $karya->diajukan_pada?->format('d/m/Y H:i') ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.karya.show', $karya) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($karya->status_karya == 'diajukan')
                            <a href="{{ route('admin.karya.review', $karya) }}" class="btn btn-sm btn-primary" title="Review">
                                <i class="fas fa-gavel"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada karya</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $karyaList->withQueryString()->links() }}
        </div>
    </div>
@stop
