@extends('layouts.admin')

@section('title', 'Manajemen Kata Sambutan')

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h6 class="mb-0">Daftar Kata Sambutan</h6>
            <a href="{{ route('admin.kata-sambutan.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive-wrapper">
                <table class="table table-hover table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th style="width: 80px;">Foto</th>
                            <th>Nama Tokoh</th>
                            <th class="d-none d-md-table-cell">Jabatan</th>
                            <th>Judul</th>
                            <th style="width: 80px;">Status</th>
                            <th style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sambutanList as $index => $sambutan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img src="{{ $sambutan->foto_url }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $sambutan->nama_tokoh }}">
                            </td>
                            <td class="fw-medium">{{ $sambutan->nama_tokoh }}</td>
                            <td class="d-none d-md-table-cell small">{{ $sambutan->jabatan ?? '-' }}</td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;">{{ Str::limit($sambutan->judul, 40) }}</div>
                            </td>
                            <td>
                                @if($sambutan->status_aktif)
                                <span class="badge bg-success small">Aktif</span>
                                @else
                                <span class="badge bg-secondary small">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.kata-sambutan.edit', $sambutan) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.kata-sambutan.destroy', $sambutan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus sambutan ini?')">
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
                            <td colspan="7" class="text-center py-4">Belum ada kata sambutan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
