@extends('layouts.admin')

@section('title', 'Manajemen Kata Sambutan')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Manajemen Kata Sambutan</h1>
        <a href="{{ route('admin.kata-sambutan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i> Tambah Sambutan
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
                        <th>Foto</th>
                        <th>Nama Tokoh</th>
                        <th>Jabatan</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sambutanList as $index => $sambutan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <img src="{{ $sambutan->foto_url }}" class="img-thumbnail" style="max-height: 60px;" alt="{{ $sambutan->nama_tokoh }}">
                        </td>
                        <td>{{ $sambutan->nama_tokoh }}</td>
                        <td>{{ $sambutan->jabatan ?? '-' }}</td>
                        <td>{{ Str::limit($sambutan->judul, 50) }}</td>
                        <td>
                            @if($sambutan->status_aktif)
                            <span class="badge badge-success">Aktif</span>
                            @else
                            <span class="badge badge-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.kata-sambutan.edit', $sambutan) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.kata-sambutan.destroy', $sambutan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus sambutan ini?')">
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
                        <td colspan="7" class="text-center">Belum ada kata sambutan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
