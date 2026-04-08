@extends('layouts.admin')

@section('title', 'Manajemen Slider')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Manajemen Slider/Banner</h1>
        <a href="{{ route('admin.slider.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i> Tambah Slider
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Preview</th>
                        <th>Judul</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sliders as $index => $slider)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <img src="{{ asset('storage/'.$slider->gambar) }}" class="img-thumbnail" style="max-height: 80px;" alt="{{ $slider->judul }}">
                        </td>
                        <td>
                            {{ $slider->judul }}
                            @if($slider->subjudul)
                            <br><small class="text-muted">{{ Str::limit($slider->subjudul, 50) }}</small>
                            @endif
                        </td>
                        <td>{{ $slider->urutan }}</td>
                        <td>
                            @if($slider->status_aktif)
                            <span class="badge badge-success">Aktif</span>
                            @else
                            <span class="badge badge-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.slider.edit', $slider) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.slider.destroy', $slider) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus slider ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada slider</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
