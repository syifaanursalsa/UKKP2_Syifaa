@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0">Kategori Pengaduan</h5>
        <a href="{{ route('kategori.create') }}" class="btn btn-sm text-white" style="background: #14b8a6;">
            <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Pengaduan</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategoris as $k)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration }}</td>
                            <td><span class="badge text-bg-secondary">{{ $k->nama_kategori }}</span></td>
                            <td>{{ $k->pengaduan_count }}</td>
                            <td class="text-end pe-3">
                                <a href="{{ route('kategori.edit', $k->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('kategori.destroy', $k->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus kategori ini? Pengaduan terkait tidak akan terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection