@extends('layouts.admin')

@section('title', 'Manajemen Karya Saya')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Manajemen Karya Saya</h1>
        <a href="{{ route('seniman.karya.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i> Tambah Karya
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
                        <th>Thumbnail</th>
                        <th>Judul Karya</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyaList as $index => $karya)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <img src="{{ $karya->thumbnail_url }}" class="img-thumbnail" style="max-height: 50px;" alt="{{ $karya->judul_karya }}">
                        </td>
                        <td>{{ $karya->judul_karya }}</td>
                        <td>{{ $karya->kategori?->nama_kategori }}</td>
                        <td>
                            <span class="badge badge-{{ $karya->status_badge_color }}">{{ $karya->status_label }}</span>
                        </td>
                        <td>{{ $karya->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($karya->canBeEditedBy(auth()->user()))
                            <a href="{{ route('seniman.karya.edit', $karya) }}" class="btn btn-sm btn-info" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endif
                            
                            @if($karya->canBeSubmitted())
                            <form action="{{ route('seniman.karya.ajukan', $karya) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin mengajukan karya ini untuk review?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" title="Ajukan Review">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                            @endif
                            
                            @if($karya->status_karya == 'draft')
                            <form action="{{ route('seniman.karya.destroy', $karya) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus karya ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            Belum ada karya. <a href="{{ route('seniman.karya.create') }}">Tambah karya sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $karyaList->links() }}
        </div>
    </div>
@stop
