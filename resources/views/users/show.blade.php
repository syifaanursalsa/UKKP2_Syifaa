@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary me-2">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h5 class="mb-0">Detail User</h5>
    </div>

    <div class="card border-0 shadow-sm" style="max-width: 600px;">
        <div class="card-body">
            <table class="table table-sm mb-0">
                <tr><th style="width: 150px;">Nama</th><td>{{ $user->nama }}</td></tr>
                <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                <tr><th>Role</th><td>{{ ucfirst($user->role) }}</td></tr>
                <tr><th>Terdaftar</th><td>{{ $user->created_at->format('d M Y') }}</td></tr>
            </table>
        </div>
    </div>
@endsection