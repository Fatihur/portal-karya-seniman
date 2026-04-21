@extends('layouts.seniman')

@section('title', 'Edit Karya')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
        <h1 class="h4 mb-0">Edit Karya</h1>
        <a href="{{ route('seniman.karya.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('seniman.karya.update', $karyaSeni) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="judul_karya" class="form-label">Judul Karya *</label>
                    <input type="text" class="form-control @error('judul_karya') is-invalid @enderror" 
                           id="judul_karya" name="judul_karya" value="{{ old('judul_karya', $karyaSeni->judul_karya) }}" required>
                    @error('judul_karya')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori *</label>
                    <select class="form-select @error('kategori_id') is-invalid @enderror" 
                            id="kategori_id" name="kategori_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori->id }}" {{ (old('kategori_id', $karyaSeni->kategori_id) == $kategori->id) ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="deskripsi_singkat" class="form-label">Deskripsi Singkat *</label>
                    <textarea class="form-control @error('deskripsi_singkat') is-invalid @enderror" 
                              id="deskripsi_singkat" name="deskripsi_singkat" rows="2" required>{{ old('deskripsi_singkat', $karyaSeni->deskripsi_singkat) }}</textarea>
                    @error('deskripsi_singkat')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="deskripsi_lengkap" class="form-label">Deskripsi Lengkap</label>
                    <textarea class="form-control @error('deskripsi_lengkap') is-invalid @enderror" 
                              id="deskripsi_lengkap" name="deskripsi_lengkap" rows="5">{{ old('deskripsi_lengkap', $karyaSeni->deskripsi_lengkap) }}</textarea>
                    @error('deskripsi_lengkap')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="tahun_karya" class="form-label">Tahun Pembuatan</label>
                            <input type="text" class="form-control @error('tahun_karya') is-invalid @enderror" 
                                   id="tahun_karya" name="tahun_karya" value="{{ old('tahun_karya', $karyaSeni->tahun_karya) }}">
                            @error('tahun_karya')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="media_karya" class="form-label">Media/Bahan</label>
                            <input type="text" class="form-control @error('media_karya') is-invalid @enderror" 
                                   id="media_karya" name="media_karya" value="{{ old('media_karya', $karyaSeni->media_karya) }}">
                            @error('media_karya')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="dimensi" class="form-label">Dimensi/Ukuran</label>
                            <input type="text" class="form-control @error('dimensi') is-invalid @enderror" 
                                   id="dimensi" name="dimensi" value="{{ old('dimensi', $karyaSeni->dimensi) }}">
                            @error('dimensi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="lokasi_asal" class="form-label">Lokasi Asal</label>
                    <input type="text" class="form-control @error('lokasi_asal') is-invalid @enderror" 
                           id="lokasi_asal" name="lokasi_asal" value="{{ old('lokasi_asal', $karyaSeni->lokasi_asal) }}">
                    @error('lokasi_asal')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Foto Utama Saat Ini</label>
                    <div class="mb-2">
                        <img src="{{ $karyaSeni->thumbnail_url }}" class="img-thumbnail" style="max-height: 150px;" alt="{{ $karyaSeni->judul_karya }}">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="thumbnail" class="form-label">Ganti Foto Utama</label>
                    <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" 
                           id="thumbnail" name="thumbnail" accept="image/*">
                    @error('thumbnail')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="file_media" class="form-label">Tambah Foto Tambahan</label>
                    <input type="file" class="form-control @error('file_media.*') is-invalid @enderror" 
                           id="file_media" name="file_media[]" accept="image/*" multiple>
                    @error('file_media.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                @if($karyaSeni->mediaKarya->count() > 0)
                <div class="mb-4">
                    <label class="form-label">Foto Tambahan Saat Ini</label>
                    <div class="row g-2">
                        @foreach($karyaSeni->mediaKarya as $media)
                        <div class="col-md-2 col-4">
                            <img src="{{ $media->url }}" class="img-thumbnail w-100" style="height: 100px; object-fit: cover;" alt="Media">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if($karyaSeni->catatan_admin_terbaru)
                <div class="alert alert-info d-flex align-items-start">
                    <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                    <div>
                        <strong>Catatan dari Admin:</strong><br>
                        {{ $karyaSeni->catatan_admin_terbaru }}
                    </div>
                </div>
                @endif
                
                <hr>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Update Karya</button>
            </form>
        </div>
    </div>
@stop
