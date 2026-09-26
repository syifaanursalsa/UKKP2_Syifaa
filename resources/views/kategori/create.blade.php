@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <h5 class="mb-4">Tambah Kategori Baru</h5>

    <div class="card col-md-5">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label small fw-semibold">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" value="{{ old('nama_kategori') }}"
                           placeholder="Contoh: Infrastruktur" required>
                </div>
                <button class="btn btn-sm text-white px-3" style="background: #14b8a6;">Simpan</button>
                <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection