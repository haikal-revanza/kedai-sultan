@extends('layouts.app')

@section('title', 'Tambah Menu')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Menu</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Nama Menu -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Menu</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama menu" value="{{ old('name') }}" required>
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select name="category" id="category" class="form-select" required>
                        <option value="makanan" {{ old('category') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="minuman" {{ old('category') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                        <option value="snack" {{ old('category') == 'snack' ? 'selected' : '' }}>Snack</option>
                    </select>
                </div>

                <!-- Harga -->
                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" name="price" id="price" class="form-control" placeholder="Masukkan harga menu" value="{{ old('price') }}" required>
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Masukkan deskripsi menu">{{ old('description') }}</textarea>
                </div>

                <!-- Gambar -->
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Menu</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
