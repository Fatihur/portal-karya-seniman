@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Manajemen Kategori</h1>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i> Tambah Kategori
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
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th>Ikon</th>
                        <th>Jumlah Karya</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoriList as $index => $kategori)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kategori->nama_kategori }}</td>
                        <td>{{ $kategori->slug }}</td>
                        <td>
                            @if($kategori->ikon)
                            <i class="{{ $kategori->ikon }}"></i> {{ $kategori->ikon }}
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $kategori->karya_seni_count }}</td>
                        <td>{{ $kategori->urutan }}</td>
                        <td>
                            @if($kategori->status_aktif)
                            <span class="badge badge-success">Aktif</span>
                            @else
                            <span class="badge badge-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.kategori.edit', $kategori) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                        <td colspan="8" class="text-center">Belum ada kategori</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
