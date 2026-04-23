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
                
                <input type="hidden" id="slug" name="slug" value="{{ old('slug', $kategori->slug) }}">
                
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                    @error('deskripsi')
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
