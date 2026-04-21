@extends('layouts.admin')

@section('title', 'Review Karya')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.karya.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">Detail Karya yang Diajukan</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <img src="{{ $karya->thumbnail_url }}" class="img-fluid rounded w-100" style="max-height: 300px; object-fit: cover;" alt="{{ $karya->judul_karya }}">
                        </div>
                        <div class="col-md-6">
                            <h5>{{ $karya->judul_karya }}</h5>
                            <p class="text-muted">{{ $karya->deskripsi_singkat }}</p>
                            
                            <div class="table-responsive-wrapper">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td style="width: 100px;"><strong>Seniman</strong></td>
                                        <td>: {{ $karya->user?->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kategori</strong></td>
                                        <td>: {{ $karya->kategori?->nama_kategori }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tahun</strong></td>
                                        <td>: {{ $karya->tahun_karya ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Media</strong></td>
                                        <td>: {{ $karya->media_karya ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    @if($karya->deskripsi_lengkap)
                    <hr>
                    <h6>Deskripsi Lengkap</h6>
                    <p>{!! nl2br(e($karya->deskripsi_lengkap)) !!}</p>
                    @endif
                </div>
            </div>
            
            @if($karya->mediaKarya->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Galeri Media Tambahan</h6>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        @foreach($karya->mediaKarya as $media)
                        <div class="col-6 col-md-3">
                            <img src="{{ $media->url }}" class="img-thumbnail w-100" style="height: 120px; object-fit: cover;" alt="Media">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">Form Review</h6>
                </div>
                <div class="card-body">
                    @if($karya->catatan_admin_terbaru)
                    <div class="alert alert-info mb-3">
                        <strong>Catatan Reviewer Sebelumnya:</strong><br>
                        {{ $karya->catatan_admin_terbaru }}
                    </div>
                    @endif
                    
                    <form action="{{ route('admin.karya.submit-review', $karya) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Review</label>
                            <select name="status" class="form-select" required>
                                <option value="">Pilih Status...</option>
                                <option value="disetujui">Setuju - Dipublikasikan</option>
                                <option value="perlu_revisi">Perlu Revisi</option>
                                <option value="ditolak">Tolak</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan untuk Seniman</label>
                            <textarea name="catatan_review" class="form-control" rows="4" placeholder="Berikan catatan atau saran perbaikan..." required></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i> Submit Review
                            </button>
                        </div>
                    </form>
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
