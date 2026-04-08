@extends('layouts.admin')

@section('title', 'Tambah Karya Baru')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Tambah Karya Baru</h1>
        <a href="{{ route('seniman.karya.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('seniman.karya.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="judul_karya">Judul Karya *</label>
                    <input type="text" class="form-control @error('judul_karya') is-invalid @enderror" 
                           id="judul_karya" name="judul_karya" value="{{ old('judul_karya') }}" required>
                    @error('judul_karya')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="kategori_id">Kategori *</label>
                    <select class="form-control @error('kategori_id') is-invalid @enderror" 
                            id="kategori_id" name="kategori_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="deskripsi_singkat">Deskripsi Singkat *</label>
                    <textarea class="form-control @error('deskripsi_singkat') is-invalid @enderror" 
                              id="deskripsi_singkat" name="deskripsi_singkat" rows="2" required>{{ old('deskripsi_singkat') }}</textarea>
                    <small class="form-text text-muted">Ringkasan singkat tentang karya Anda</small>
                    @error('deskripsi_singkat')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="deskripsi_lengkap">Deskripsi Lengkap</label>
                    <textarea class="form-control @error('deskripsi_lengkap') is-invalid @enderror" 
                              id="deskripsi_lengkap" name="deskripsi_lengkap" rows="5">{{ old('deskripsi_lengkap') }}</textarea>
                    <small class="form-text text-muted">Cerita lengkap, inspirasi, atau informasi detail tentang karya</small>
                    @error('deskripsi_lengkap')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tahun_karya">Tahun Pembuatan</label>
                            <input type="text" class="form-control @error('tahun_karya') is-invalid @enderror" 
                                   id="tahun_karya" name="tahun_karya" value="{{ old('tahun_karya') }}" placeholder="Contoh: 2023">
                            @error('tahun_karya')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="media_karya">Media/Bahan</label>
                            <input type="text" class="form-control @error('media_karya') is-invalid @enderror" 
                                   id="media_karya" name="media_karya" value="{{ old('media_karya') }}" placeholder="Contoh: Kayu, Kanvas, Batu">
                            @error('media_karya')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dimensi">Dimensi/Ukuran</label>
                            <input type="text" class="form-control @error('dimensi') is-invalid @enderror" 
                                   id="dimensi" name="dimensi" value="{{ old('dimensi') }}" placeholder="Contoh: 100cm x 80cm">
                            @error('dimensi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="lokasi_asal">Lokasi Asal</label>
                    <input type="text" class="form-control @error('lokasi_asal') is-invalid @enderror" 
                           id="lokasi_asal" name="lokasi_asal" value="{{ old('lokasi_asal') }}" placeholder="Contoh: Desa Senggigi, Kec. Batu Lanteh">
                    @error('lokasi_asal')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="thumbnail">Foto Utama/Thumbnail *</label>
                    <input type="file" class="form-control-file @error('thumbnail') is-invalid @enderror" 
                           id="thumbnail" name="thumbnail" accept="image/*" required>
                    <small class="form-text text-muted">Format: JPG, PNG, WEBP. Ukuran maksimal 5MB</small>
                    @error('thumbnail')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="file_media">Foto Tambahan (Opsional)</label>
                    <input type="file" class="form-control-file @error('file_media.*') is-invalid @enderror" 
                           id="file_media" name="file_media[]" accept="image/*" multiple>
                    <small class="form-text text-muted">Dapat memilih lebih dari 1 foto. Maksimal 10MB per file</small>
                    @error('file_media.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <hr>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Simpan sebagai Draft</button>
                    <small class="text-muted">Karya akan disimpan sebagai draft dan dapat diajukan untuk review setelah disimpan.</small>
                </div>
            </form>
        </div>
    </div>
@stop
