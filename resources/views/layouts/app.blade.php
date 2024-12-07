<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Kedai Sultan</a>
            <div class="d-flex">
                @auth
                    <span class="navbar-text me-3">Welcome, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
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
    <main>
        @yield('content')
    </main>
</body>
</html>
