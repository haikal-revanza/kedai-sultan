@extends('layouts.app')

@section('title', 'Dashboard Kasir')

@section('content')
<div class="container mt-5">
    <h1>Dashboard Kasir</h1>
    <p>Selamat datang, {{ auth()->user()->name }}!</p>
</div>
@endsection
