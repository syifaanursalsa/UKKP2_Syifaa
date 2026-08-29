@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h5 class="fw-bold text-center mb-1">Sistem Pengaduan</h5>
        <p class="text-muted text-center small mb-4">Silakan login untuk melanjutkan</p>

        {{-- Pesan error jika login gagal --}}
        @if ($errors->any())
            <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login.proses') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="text-center mt-3">
            <small>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></small>
        </div>
    </div>
</div>
@endsection