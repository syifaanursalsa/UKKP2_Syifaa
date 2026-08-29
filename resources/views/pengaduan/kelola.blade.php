@extends('layouts.app')

@section('title', 'Kelola Pengaduan')

@section('content')
    <h5 class="mb-4">Kelola Pengaduan</h5>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th>Nama Customer</th>
                            <th>Pengaduan</th>
                            <th>Foto</th>
                            <th>Tanggal</th>
                            <th style="width: 200px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengaduan as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->user->nama }}</td>
                                <td>{{ Str::limit($p->pengaduan, 60) }}</td>
                                <td>
                                    @if ($p->foto)
                                        <img src="{{ asset('storage/' . $p->foto) }}" class="rounded" style="max-height: 50px;" alt="Foto">
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>{{ $p->created_at->format('d M Y') }}</td>
                                <td>
                                    {{-- Form kecil untuk mengubah status --}}
                                    <form action="{{ route('kelola.status', $p->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group input-group-sm">
                                            <select name="status" class="form-select">
                                                @foreach (['menunggu', 'diproses', 'selesai'] as $s)
                                                    <option value="{{ $s }}" {{ $p->status == $s ? 'selected' : '' }}>
                                                        {{ ucfirst($s) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-outline-primary" title="Simpan status">
                                                <i class="bi bi-save"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted">Belum ada pengaduan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection