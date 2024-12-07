@extends('admin.dashboard')

@section('content')
<div class="container">
    <h1>Daftar Menu</h1>
    <a href="{{ route('admin.menus.create') }}" class="btn btn-primary mb-3">Tambah Menu</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menus as $menu)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $menu->name }}</td>
                <td>{{ ucfirst($menu->category) }}</td>
                <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                <td>
                    @if($menu->image_url)
                        <img src="{{ asset('storage/' . $menu->image_url) }}" alt="Gambar Menu" width="100">
                    @else
                        Tidak ada gambar
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.menus.edit', $menu->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                    @if($menu->image_url)
                        <a href="{{ route('admin.menus.download', $menu->id) }}" class="btn btn-info btn-sm">Download Gambar</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
