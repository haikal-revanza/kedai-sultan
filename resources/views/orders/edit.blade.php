@extends('layouts.customer')

@section('title', 'Edit Pesanan')

@section('content')
<div class="container-fluid p-3">
    <h3 class="mb-3 text-center">Edit Pesanan</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('order.update') }}" method="POST" id="update-order-form">
        @csrf

        <div class="mb-4">
            @foreach($menus as $menu)
            <div class="d-flex align-items-center mb-3" data-menu-id="{{ $menu->id }}">
                <img src="{{ asset('storage/' . $menu->image_url) }}" alt="{{ $menu->name }}" class="img-thumbnail" style="width: 80px; height: 80px;">
                <div class="ms-3 flex-grow-1">
                    <h6 class="mb-0">{{ $menu->name }}</h6>
                    <small class="text-muted">Rp {{ number_format($menu->price, 0, ',', '.') }}</small>
                </div>
                <div class="input-group" style="width: 120px;">
                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQuantity('{{ $menu->id }}', -1)">-</button>
                    <input type="number" class="form-control text-center" name="orders[{{ $menu->id }}]" id="quantity-{{ $menu->id }}" value="{{ $orders[$menu->id] }}" readonly>
                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQuantity('{{ $menu->id }}', 1)">+</button>
                </div>
                <button type="button" class="btn btn-danger btn-sm ms-3" onclick="removeItem('{{ $menu->id }}')">Hapus</button>
            </div>
            @endforeach
        </div>

        <div class="fixed-bottom bg-white p-3 border-top">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Total: Rp <span id="total-price">0</span></h5>
                <button type="submit" class="btn btn-success">Konfirmasi</button>
            </div>
        </div>
    </form>
</div>

<script>
    function updateQuantity(menuId, change) {
        const input = document.getElementById(`quantity-${menuId}`);
        let currentQuantity = parseInt(input.value) || 0;
        currentQuantity += change;

        if (currentQuantity < 0) {
            currentQuantity = 0;
        }

        input.value = currentQuantity;
        calculateTotal();
    }

    function removeItem(menuId) {
        // Temukan elemen container berdasarkan menu ID
        const menuElement = document.querySelector(`[data-menu-id="${menuId}"]`);

        if (menuElement) {
            // Hapus elemen dari DOM
            menuElement.remove();

            // Set nilai quantity menjadi 0 agar tidak dihitung di server
            const input = document.getElementById(`quantity-${menuId}`);
            if (input) {
                input.value = 0;
            }

            // Perbarui total harga
            calculateTotal();
        }
    }

    function calculateTotal() {
        let total = 0;

        document.querySelectorAll('input[id^="quantity-"]').forEach(input => {
            const menuId = input.id.split('-')[1];
            const priceElement = input.closest('.d-flex').querySelector('.text-muted');
            const price = parseInt(priceElement.textContent.replace(/[^\d]/g, '')) || 0;

            total += price * parseInt(input.value || 0);
        });

        document.getElementById('total-price').textContent = total.toLocaleString('id-ID');
    }

    calculateTotal();
</script>
@endsection
