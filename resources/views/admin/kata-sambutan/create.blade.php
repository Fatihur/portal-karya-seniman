@extends('layouts.admin')

@section('title', 'Tambah Kata Sambutan')

@section('content_header')
    <h1>Tambah Kata Sambutan</h1>
    <a href="{{ route('admin.kata-sambutan.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.kata-sambutan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="judul">Judul *</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                           id="judul" name="judul" value="{{ old('judul') }}" required>
                    @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="nama_tokoh">Nama Tokoh *</label>
                    <input type="text" class="form-control @error('nama_tokoh') is-invalid @enderror" 
                           id="nama_tokoh" name="nama_tokoh" value="{{ old('nama_tokoh') }}" required>
                    @error('nama_tokoh')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" class="form-control @error('jabatan') is-invalid @enderror" 
                           id="jabatan" name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Kepala Dinas Kebudayaan">
                    @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="foto">Foto Tokoh</label>
                    <input type="file" class="form-control-file @error('foto') is-invalid @enderror" 
                           id="foto" name="foto" accept="image/*">
                    @error('foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="isi_sambutan">Isi Sambutan *</label>
                    <textarea class="form-control @error('isi_sambutan') is-invalid @enderror" 
                              id="isi_sambutan" name="isi_sambutan" rows="6" required>{{ old('isi_sambutan') }}</textarea>
                    @error('isi_sambutan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="status_aktif" name="status_aktif" value="1" checked>
                        <label class="custom-control-label" for="status_aktif">Tampilkan di Website</label>
                    </div>
                    <small class="form-text text-muted">Hanya satu sambutan yang akan ditampilkan di halaman publik.</small>
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@stop
