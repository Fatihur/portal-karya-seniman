@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content_header')
    <h1>Edit Kategori</h1>
    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="nama_kategori">Nama Kategori *</label>
                    <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" 
                           id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                    @error('nama_kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                           id="slug" name="slug" value="{{ old('slug', $kategori->slug) }}">
                    @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                    @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group icon-picker-container">
                    <label for="ikon">Ikon Kategori</label>
                    <div class="d-flex align-items-center gap-2">
                        <div id="icon-preview" class="icon-preview-box" title="Klik untuk memilih icon">
                            <i class="bi {{ $kategori->ikon ?? 'bi-image' }}"></i>
                        </div>
                        <input type="text" class="form-control @error('ikon') is-invalid @enderror" 
                               id="ikon" name="ikon" value="{{ old('ikon', $kategori->ikon) }}" readonly 
                               placeholder="Klik icon di sebelah kiri" style="cursor: pointer;">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="document.getElementById('ikon').value=''; document.getElementById('icon-preview').innerHTML='<i class=\'bi bi-image\'></i>'; document.getElementById('icon-preview').classList.remove('has-icon');">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div id="icon-picker-dropdown" class="icon-picker-dropdown"></div>
                    <small class="form-text text-muted">Klik kotak icon untuk membuka picker</small>
                    @error('ikon')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                @if($kategori->gambar)
                <div class="form-group">
                    <label>Gambar Saat Ini</label>
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$kategori->gambar) }}" class="img-thumbnail" style="max-height: 150px;" alt="{{ $kategori->nama_kategori }}">
                    </div>
                </div>
                @endif
                
                <div class="form-group">
                    <label for="gambar">Ganti Gambar Kategori</label>
                    <input type="file" class="form-control-file @error('gambar') is-invalid @enderror" 
                           id="gambar" name="gambar" accept="image/*">
                    @error('gambar')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="urutan">Urutan</label>
                    <input type="number" class="form-control @error('urutan') is-invalid @enderror" 
                           id="urutan" name="urutan" value="{{ old('urutan', $kategori->urutan) }}">
                    @error('urutan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="status_aktif" name="status_aktif" value="1" {{ $kategori->status_aktif ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status_aktif">Aktif</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@stop
