@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
    <div class="bg-light p-3" style="width: 250px; height: 100vh;">
        <h4>Kedai Sultan</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.menus.index') }}" class="nav-link {{ request()->is('admin/menus*') ? 'active' : '' }}">CRUD Menu</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Laporan</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Tambah User</a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="container-fluid p-4">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, {{ Auth::user()->name }}!</p>
    </div>
</div>
@endsection
