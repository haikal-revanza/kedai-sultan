<form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nama Menu</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
    </div>

    <div class="mb-3">
        <label for="category" class="form-label">Kategori</label>
        <select class="form-control" id="category" name="category" required>
            <option value="makanan" {{ old('category') == 'makanan' ? 'selected' : '' }}>Makanan</option>
            <option value="minuman" {{ old('category') == 'minuman' ? 'selected' : '' }}>Minuman</option>
            <option value="snack" {{ old('category') == 'snack' ? 'selected' : '' }}>Snack</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Harga</label>
        <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Gambar Menu</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">Batal</a>
</form>
