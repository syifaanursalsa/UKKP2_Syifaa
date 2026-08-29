@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <h5 class="mb-1">Profil Saya</h5>
    <p class="text-muted mb-4">Lihat dan ubah informasi akun Anda.</p>

    <div class="row g-4">
        {{-- Kolom kiri: info profil --}}
        <div class="col-md-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-person-fill text-secondary" style="font-size: 2.5rem;"></i>
                    </div>
                    <h6 class="fw-bold mb-1">{{ $user->nama }}</h6>
                    <p class="text-muted small mb-2">{{ $user->email }}</p>
                    @php
                        $badge = [
                            'admin' => 'text-bg-danger',
                            'petugas' => 'text-bg-warning',
                            'customer' => 'text-bg-info',
                        ][$user->role] ?? 'text-bg-secondary';
                    @endphp
                    <span class="badge {{ $badge }}">{{ ucfirst($user->role) }}</span>
                    <hr>
                    <p class="small text-muted mb-0">
                        Terdaftar sejak {{ $user->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Kolom kanan: form edit profil --}}
        <div class="col-md-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Ubah Profil</h6>

                    @if ($errors->any())
                        <div class="alert alert-danger py-2 small">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control"
                                   value="{{ old('nama', $user->nama) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti password.</small>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection