@extends('layouts.admin')

@section('title', 'Manajemen Slider')

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h6 class="mb-0">Daftar Slider/Banner</h6>
            <a href="{{ route('admin.slider.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive-wrapper">
                <table class="table table-hover table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th style="width: 120px;">Preview</th>
                            <th>Judul</th>
                            <th style="width: 80px;">Status</th>
                            <th style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sliders as $index => $slider)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img src="{{ asset('storage/'.$slider->gambar) }}" class="img-thumbnail" style="width: 100px; height: 60px; object-fit: cover;" alt="{{ $slider->judul }}">
                            </td>
                            <td>
                                <div class="fw-medium">{{ $slider->judul }}</div>
                                @if($slider->subjudul)
                                <small class="text-muted d-none d-md-block">{{ Str::limit($slider->subjudul, 40) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($slider->status_aktif)
                                <span class="badge bg-success small">Aktif</span>
                                @else
                                <span class="badge bg-danger small">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.slider.edit', $slider) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.slider.destroy', $slider) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus slider ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Belum ada slider</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
    
    .table-responsive-wrapper table {
        min-width: 600px;
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
