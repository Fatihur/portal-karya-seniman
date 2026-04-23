@extends('layouts.admin')

@section('title', 'Edit Slider')

@section('content_header')
    <h1>Edit Slider</h1>
    <a href="{{ route('admin.slider.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.slider.update', $slider) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="judul">Judul *</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                           id="judul" name="judul" value="{{ old('judul', $slider->judul) }}" required>
                    @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="subjudul">Sub Judul</label>
                    <textarea class="form-control @error('subjudul') is-invalid @enderror" 
                              id="subjudul" name="subjudul" rows="2">{{ old('subjudul', $slider->subjudul) }}</textarea>
                    @error('subjudul')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Gambar Saat Ini</label>
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$slider->gambar) }}" class="img-thumbnail" style="max-height: 200px;" alt="{{ $slider->judul }}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="gambar">Ganti Gambar</label>
                    <input type="file" class="form-control-file @error('gambar') is-invalid @enderror" 
                           id="gambar" name="gambar" accept="image/*">
                    @error('gambar')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="status_aktif" name="status_aktif" value="1" {{ $slider->status_aktif ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status_aktif">Aktif</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@stop
