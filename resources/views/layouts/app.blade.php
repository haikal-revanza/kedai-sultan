<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @section('sidebar')
        <aside class="bg-light vh-100" style="width: 250px;">
            @include('layouts.navigation') <!-- Navigasi sidebar -->
        </aside>
        @show

        <!-- Main Content -->
        <div class="flex-grow-1">
            <nav class="navbar navbar-light bg-light px-3">
                <div class="d-flex w-100 justify-content-between">
                    <span class="navbar-brand">Kedai Sultan</span>
                    <div>
                        @auth
                            <span class="navbar-text me-3">Welcome, {{ Auth::user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">Logout</button>
                            </form>
                        @endauth

                        @guest
                            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        @endguest
                    </div>
                </div>
            </nav>
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>
