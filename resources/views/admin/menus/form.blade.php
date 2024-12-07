@extends('admin.dashboard')

@section('content')
<div class="container">
    <h1>{{ isset($menu) ? 'Edit Menu' : 'Tambah Menu' }}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($menu) ? route('admin.menus.update', $menu->id) : route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($menu))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Nama Menu</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ isset($menu) ? $menu->name : old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <select name="category" id="category" class="form-control">
                <option value="makanan" {{ isset($menu) && $menu->category === 'makanan' ? 'selected' : '' }}>Makanan</option>
                <option value="minuman" {{ isset($menu) && $menu->category === 'minuman' ? 'selected' : '' }}>Minuman</option>
                <option value="snack" {{ isset($menu) && $menu->category === 'snack' ? 'selected' : '' }}>Snack</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ isset($menu) ? $menu->price : old('price') }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Gambar</label>
            <input type="file" name="image" id="image" class="form-control">
            @if(isset($menu) && $menu->image_url)
                <p><small>Gambar saat ini: <a href="{{ route('admin.menus.download', $menu->id) }}">{{ $menu->image_url }}</a></small></p>
            @endif
        </div>

        <button type="submit" class="btn btn-success">{{ isset($menu) ? 'Update' : 'Simpan' }}</button>
    </form>
</div>
@endsection