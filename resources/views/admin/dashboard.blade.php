@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h5 class="mb-1">Selamat datang, {{ auth()->user()->nama }}</h5>
    <p class="text-muted mb-4">Ringkasan data sistem pengaduan.</p>

    <div class="row g-3">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm border-start border-4 border-primary">
                <div class="card-body">
                    <p class="text-muted small mb-1"><i class="bi bi-people me-1"></i>Total User</p>
                    <h4 class="fw-bold mb-0">{{ $totalUser }}</h4>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm border-start border-4 border-info">
                <div class="card-body">
                    <p class="text-muted small mb-1"><i class="bi bi-person me-1"></i>Customer</p>
                    <h4 class="fw-bold mb-0">{{ $totalCustomer }}</h4>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm border-start border-4 border-warning">
                <div class="card-body">
                    <p class="text-muted small mb-1"><i class="bi bi-headset me-1"></i>Petugas</p>
                    <h4 class="fw-bold mb-0">{{ $totalPetugas }}</h4>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm border-start border-4 border-success">
                <div class="card-body">
                    <p class="text-muted small mb-1"><i class="bi bi-clipboard-data me-1"></i>Pengaduan</p>
                    <h4 class="fw-bold mb-0">{{ $totalPengaduan }}</h4>
                </div>
            </div>
        </div>
    </div>
@endsection