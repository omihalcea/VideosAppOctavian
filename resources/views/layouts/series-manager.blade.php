<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @auth
        <meta name="user-id" content="{{ auth()->id() }}">
    @endauth
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestió de Series')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <style>
        footer {
            margin-top: auto;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('users.index') }}">Gestió d'Usuaris</a>
        <a class="navbar-brand" href="{{ route('videos.index') }}">Gestió de Vídeos</a>
        <a class="navbar-brand" href="{{ route('series.index') }}">Gestió de Sèries</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <a class="navbar-brand position-relative" href="{{ route('notifications.view') }}" title="Notificacions">
                    <i class="bi bi-bell-fill"></i>
                </a>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('series.index') }}">Llistat de Sèries</a>
                    </li>
                @endauth
                @can('manage-series')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('series.manage.index') }}">Gestió de Sèries</a>
                    </li>
                @endcan
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar Sessió</a>
                    </li>
                @else
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-white">Sortir</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4 flex-grow-1">
    @yield('content')
</main>

<footer class="bg-dark text-white text-center py-3 mt-4">
    &copy; {{ date('Y') }} Gestió de Sèries
</footer>

@yield('scripts', '')
</body>
</html>
