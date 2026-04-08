@extends('layouts.admin')

@section('title', 'Review Karya')

@section('content_header')
    <h1>Review Karya</h1>
    <a href="{{ route('admin.karya.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning">
                    <h3 class="card-title">Detail Karya yang Diajukan</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ $karya->thumbnail_url }}" class="img-fluid rounded" alt="{{ $karya->judul_karya }}">
                        </div>
                        <div class="col-md-6">
                            <h4>{{ $karya->judul_karya }}</h4>
                            <p class="text-muted">{{ $karya->deskripsi_singkat }}</p>
                            
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Seniman</strong></td>
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
                    
                    @if($karya->deskripsi_lengkap)
                    <hr>
                    <h5>Deskripsi Lengkap</h5>
                    <p>{!! nl2br(e($karya->deskripsi_lengkap)) !!}</p>
                    @endif
                </div>
            </div>
            
            @if($karya->mediaKarya->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Galeri Media Tambahan</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($karya->mediaKarya as $media)
                        <div class="col-md-3 mb-3">
                            <img src="{{ $media->url }}" class="img-thumbnail w-100" style="height: 150px; object-fit: cover;" alt="Media">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Form Review</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.karya.submit-review', $karya) }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label>Status Review *</label>
                            <div class="d-flex flex-column gap-2">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="status" id="status_disetujui" value="disetujui" required>
                                    <label class="custom-control-label" for="status_disetujui">
                                        <span class="badge badge-success">Setujui & Publikasikan</span>
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="status" id="status_revisi" value="perlu_revisi">
                                    <label class="custom-control-label" for="status_revisi">
                                        <span class="badge badge-warning">Perlu Revisi</span>
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="status" id="status_ditolak" value="ditolak">
                                    <label class="custom-control-label" for="status_ditolak">
                                        <span class="badge badge-danger">Tolak</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="catatan_review">Catatan Review *</label>
                            <textarea class="form-control @error('catatan_review') is-invalid @enderror" 
                                      id="catatan_review" name="catatan_review" rows="4" required
                                      placeholder="Berikan catatan untuk seniman...">{{ old('catatan_review') }}</textarea>
                            @error('catatan_review')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save mr-1"></i> Simpan Review
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
