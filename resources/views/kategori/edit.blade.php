@extends('layouts.app')
@section('title', 'Edit Kategori')
@section('content')
    <h5 class="mb-4">Edit Kategori</h5>
    <div class="card col-md-5">
        <div class="card-body">
            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="form-label small fw-semibold">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                </div>
                <button class="btn btn-sm text-white px-3" style="background: #14b8a6;">Simpan Perubahan</button>
                <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection