@extends('layouts.customer')

@section('title', 'Pilih Menu')

@section('content')
<div class="container-fluid p-3">
    <!-- Header -->
    <h3 class="mb-3 text-center">Pilih Menu</h3>

    <!-- Kategori Navigasi -->
    <div class="d-flex justify-content-center mb-4">
        <button class="btn btn-outline-primary me-2 active" onclick="filterMenu('makanan')">Makanan</button>
        <button class="btn btn-outline-primary me-2" onclick="filterMenu('minuman')">Minuman</button>
        <button class="btn btn-outline-primary" onclick="filterMenu('snack')">Snack</button>
    </div>

    <!-- Daftar Menu -->
    <div id="menu-list">
        <!-- Makanan -->
        <div class="menu-section" data-category="makanan">
            <h4>Makanan</h4>
            <div class="row">
                @foreach($makanan as $menu)
                <div class="col-12 mb-3">
                    <div class="d-flex align-items-center" data-menu-id="{{ $menu->id }}">
                        <img src="{{ asset('storage/' . $menu->image_url) }}" alt="{{ $menu->name }}" class="img-thumbnail" style="width: 80px; height: 80px;">
                        <div class="ms-3 flex-grow-1">
                            <h6 class="mb-0">{{ $menu->name }}</h6>
                            <small class="text-muted">Rp {{ number_format($menu->price, 0, ',', '.') }}</small>
                        </div>
                        <div class="input-group" style="width: 120px;">
                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity('{{ $menu->id }}', -1)">-</button>
                            <input type="number" class="form-control text-center" id="quantity-{{ $menu->id }}" value="0" readonly>
                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity('{{ $menu->id }}', 1)">+</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Minuman -->
        <div class="menu-section d-none" data-category="minuman">
            <h4>Minuman</h4>
            <div class="row">
                @foreach($minuman as $menu)
                <div class="col-12 mb-3">
                    <div class="d-flex align-items-center" data-menu-id="{{ $menu->id }}">
                        <img src="{{ asset('storage/' . $menu->image_url) }}" alt="{{ $menu->name }}" class="img-thumbnail" style="width: 80px; height: 80px;">
                        <div class="ms-3 flex-grow-1">
                            <h6 class="mb-0">{{ $menu->name }}</h6>
                            <small class="text-muted">Rp {{ number_format($menu->price, 0, ',', '.') }}</small>
                        </div>
                        <div class="input-group" style="width: 120px;">
                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity('{{ $menu->id }}', -1)">-</button>
                            <input type="number" class="form-control text-center" id="quantity-{{ $menu->id }}" value="0" readonly>
                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity('{{ $menu->id }}', 1)">+</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Snack -->
        <div class="menu-section d-none" data-category="snack">
            <h4>Snack</h4>
            <div class="row">
                @foreach($snack as $menu)
                <div class="col-12 mb-3">
                    <div class="d-flex align-items-center" data-menu-id="{{ $menu->id }}">
                        <img src="{{ asset('storage/' . $menu->image_url) }}" alt="{{ $menu->name }}" class="img-thumbnail" style="width: 80px; height: 80px;">
                        <div class="ms-3 flex-grow-1">
                            <h6 class="mb-0">{{ $menu->name }}</h6>
                            <small class="text-muted">Rp {{ number_format($menu->price, 0, ',', '.') }}</small>
                        </div>
                        <div class="input-group" style="width: 120px;">
                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity('{{ $menu->id }}', -1)">-</button>
                            <input type="number" class="form-control text-center" id="quantity-{{ $menu->id }}" value="0" readonly>
                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity('{{ $menu->id }}', 1)">+</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Checkout Section -->
    <form action="{{ route('order.store') }}" method="POST" id="order-form">
        @csrf
        <div class="fixed-bottom bg-white p-3 border-top">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Total: Rp <span id="total-price">0</span></h5>
                <button type="button" class="btn btn-success" onclick="submitOrder()">Pesan</button>
            </div>
        </div>
    </form>
</div>

<script>
    // Fungsi untuk mengatur filter kategori menu
    function filterMenu(category) {
        document.querySelectorAll('.menu-section').forEach(section => {
            section.classList.add('d-none');
            if (section.getAttribute('data-category') === category) {
                section.classList.remove('d-none');
            }
        });

        document.querySelectorAll('.btn-outline-primary').forEach(button => {
            button.classList.remove('active');
        });
        document.querySelector(`button[onclick="filterMenu('${category}')"]`).classList.add('active');
    }

    // Fungsi untuk memperbarui jumlah pesanan
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

    // Fungsi untuk menghitung total harga
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

    // Fungsi untuk mengirimkan pesanan
    function submitOrder() {
        const form = document.getElementById('order-form');
        const inputs = document.createElement('div');

        document.querySelectorAll('input[id^="quantity-"]').forEach(input => {
            const menuId = input.id.split('-')[1];
            const quantity = parseInt(input.value) || 0;

            if (quantity > 0) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `orders[${menuId}]`;
                hiddenInput.value = quantity;
                inputs.appendChild(hiddenInput);
            }
        });

        form.appendChild(inputs);
        form.submit();
    }

    // Default kategori aktif (Makanan)
    filterMenu('makanan');
</script>
@endsection
