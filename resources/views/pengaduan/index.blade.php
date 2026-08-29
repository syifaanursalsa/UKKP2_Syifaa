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
                            <th>Isi Pengaduan</th>
                            <th>Status</th>
                            <th style="width: 80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengaduan as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->created_at->format('d M Y') }}</td>
                                <td>{{ Str::limit($p->pengaduan, 60) }}</td>
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
                            <tr><td colspan="5" class="text-center text-muted">Belum ada pengaduan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection