@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container mt-5">
    <h1>Dashboard Admin</h1>
    <p>Selamat datang, {{ auth()->user()->name }}!</p>
</div>
@endsection