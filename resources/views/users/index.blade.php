@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0">Data User</h5>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-person-plus me-1"></i>Tambah User
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            @if (auth()->user()->role == 'admin')
                                <th style="width: 130px;">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                {{-- Warna badge mengikuti role --}}
                                @php
                                    $badge = [
                                        'admin' => 'text-bg-danger',
                                        'petugas' => 'text-bg-warning',
                                        'customer' => 'text-bg-info',
                                    ][$user->role] ?? 'text-bg-secondary';
                                @endphp
                                <td><span class="badge {{ $badge }}">{{ ucfirst($user->role) }}</span></td>

                                {{-- Tombol aksi hanya untuk admin --}}
                                @if (auth()->user()->role == 'admin')
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection