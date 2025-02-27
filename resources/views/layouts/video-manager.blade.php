<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestió de Vídeos')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('videos.index') }}">Gestió de Vídeos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
{{--                    <a class="nav-link" href="{{ route('manage.index') }}">Llista de Vídeos</a>--}}
                </li>
                @can('manage_videos')
                    <li class="nav-item">
{{--                        <a class="nav-link" href="{{ route('videos.create') }}">Afegir Vídeo</a>--}}
                    </li>
                @endcan
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Sortir</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4">
    @yield('content')
</main>

<footer class="bg-dark text-white text-center py-3 mt-4">
    &copy; {{ date('Y') }} Gestió de Vídeos
</footer>
</body>
</html>
