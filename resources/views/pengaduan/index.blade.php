@extends('layouts.app')

@section('title', 'Pengaduan Saya')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0">Pengaduan Saya</h5>
        <a href="{{ route('pengaduan.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i>Buat Pengaduan
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Isi Pengaduan</th>
                            <th style="width: 90px;">Foto</th>
                            <th>Status</th>
                            <th style="width: 80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengaduan as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->created_at->format('d M Y') }}</td>
                                <td>
                                    @if ($p->kategori)
                                        <span class="badge text-bg-secondary">{{ $p->kategori->nama_kategori }}</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($p->pengaduan, 60) }}</td>
                                <td>
                                    @if ($p->foto)
                                        <img src="{{ Storage::url($p->foto) }}" alt="Foto bukti"
                                             style="width: 55px; height: 55px; object-fit: cover; border-radius: .4rem;">
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $badge = [
                                            'menunggu' => 'text-bg-warning',
                                            'diproses' => 'text-bg-primary',
                                            'selesai' => 'text-bg-success',
                                        ][$p->status] ?? 'text-bg-secondary';
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ ucfirst($p->status) }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('pengaduan.show', $p->id) }}" class="btn btn-sm btn-outline-primary" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">Belum ada pengaduan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection