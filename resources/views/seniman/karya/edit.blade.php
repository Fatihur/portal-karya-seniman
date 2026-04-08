@extends('layouts.admin')

@section('title', 'Edit Karya')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Edit Karya</h1>
        <a href="{{ route('seniman.karya.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('seniman.karya.update', $karyaSeni) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="judul_karya">Judul Karya *</label>
                    <input type="text" class="form-control @error('judul_karya') is-invalid @enderror" 
                           id="judul_karya" name="judul_karya" value="{{ old('judul_karya', $karyaSeni->judul_karya) }}" required>
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
                        <option value="{{ $kategori->id }}" {{ (old('kategori_id', $karyaSeni->kategori_id) == $kategori->id) ? 'selected' : '' }}>
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
                              id="deskripsi_singkat" name="deskripsi_singkat" rows="2" required>{{ old('deskripsi_singkat', $karyaSeni->deskripsi_singkat) }}</textarea>
                    @error('deskripsi_singkat')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="deskripsi_lengkap">Deskripsi Lengkap</label>
                    <textarea class="form-control @error('deskripsi_lengkap') is-invalid @enderror" 
                              id="deskripsi_lengkap" name="deskripsi_lengkap" rows="5">{{ old('deskripsi_lengkap', $karyaSeni->deskripsi_lengkap) }}</textarea>
                    @error('deskripsi_lengkap')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tahun_karya">Tahun Pembuatan</label>
                            <input type="text" class="form-control @error('tahun_karya') is-invalid @enderror" 
                                   id="tahun_karya" name="tahun_karya" value="{{ old('tahun_karya', $karyaSeni->tahun_karya) }}">
                            @error('tahun_karya')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="media_karya">Media/Bahan</label>
                            <input type="text" class="form-control @error('media_karya') is-invalid @enderror" 
                                   id="media_karya" name="media_karya" value="{{ old('media_karya', $karyaSeni->media_karya) }}">
                            @error('media_karya')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="dimensi">Dimensi/Ukuran</label>
                            <input type="text" class="form-control @error('dimensi') is-invalid @enderror" 
                                   id="dimensi" name="dimensi" value="{{ old('dimensi', $karyaSeni->dimensi) }}">
                            @error('dimensi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="lokasi_asal">Lokasi Asal</label>
                    <input type="text" class="form-control @error('lokasi_asal') is-invalid @enderror" 
                           id="lokasi_asal" name="lokasi_asal" value="{{ old('lokasi_asal', $karyaSeni->lokasi_asal) }}">
                    @error('lokasi_asal')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Foto Utama Saat Ini</label>
                    <div class="mb-2">
                        <img src="{{ $karyaSeni->thumbnail_url }}" class="img-thumbnail" style="max-height: 150px;" alt="{{ $karyaSeni->judul_karya }}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="thumbnail">Ganti Foto Utama</label>
                    <input type="file" class="form-control-file @error('thumbnail') is-invalid @enderror" 
                           id="thumbnail" name="thumbnail" accept="image/*">
                    @error('thumbnail')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="file_media">Tambah Foto Tambahan</label>
                    <input type="file" class="form-control-file @error('file_media.*') is-invalid @enderror" 
                           id="file_media" name="file_media[]" accept="image/*" multiple>
                    @error('file_media.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                @if($karyaSeni->mediaKarya->count() > 0)
                <div class="form-group">
                    <label>Foto Tambahan Saat Ini</label>
                    <div class="row">
                        @foreach($karyaSeni->mediaKarya as $media)
                        <div class="col-md-2 mb-2">
                            <img src="{{ $media->url }}" class="img-thumbnail w-100" style="height: 100px; object-fit: cover;" alt="Media">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if($karyaSeni->catatan_admin_terbaru)
                <div class="alert alert-info">
                    <strong>Catatan dari Admin:</strong><br>
                    {{ $karyaSeni->catatan_admin_terbaru }}
                </div>
                @endif
                
                <button type="submit" class="btn btn-primary">Update Karya</button>
            </form>
        </div>
    </div>
@stop
