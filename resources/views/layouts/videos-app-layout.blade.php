<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalls del Vídeo</title>
</head>
<body>

<!-- Navbar -->
<header class="bg-green-600 text-white">
    <div class="container head-cont mx-auto px-4 py-3 flex justify-between items-center">
        <a href="{{ route('videos.index') }}" class="text-xl font-bold">VideosApp</a>
        <nav class="space-x-4">
            <a href="{{ route('videos.index') }}" class="hover:text-gray-200">Inici</a>
            <a href="{{ route('manage.create') }}" class="hover:text-gray-200">Afegir Vídeo</a>
            <a href="{{ route('manage.index') }}" class="hover:text-gray-200">Gestió</a>
        </nav>
    </div>
</header>
<main>
    {{ $slot }}
</main>

<!-- Footer -->
<footer class="bg-gray-800 text-white text-center py-4">
    <p>&copy; {{ date('Y') }} VideosApp. Tots els drets reservats.</p>
</footer>
</body>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
        color: #333;
        line-height: 1.6;
    }

    .container {
        max-width: 800px;
        margin: 50px auto;
        background: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }
    .header {
        background-color: #4CAF50;
        color: white;
        padding: 20px;
        text-align: center;
    }
    .content {
        padding: 20px;
    }
    h1 {
        font-size: 24px;
        color: #ffffff;
    }
    p {
        margin: 10px 0;
    }

    a {
        color: #4CAF50;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
    iframe {
        display: block;
        margin: 20px auto;
        max-width: 100%;
        border-radius: 8px;
    }

    .links {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
    }

    .links a {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border-radius: 4px;
        text-decoration: none;
    }

    .links a:hover {
        background-color: #45a049;
    }

    header {
        background-color: #4CAF50;
        color: green;
        padding: 20px;
        text-align: center;
    }

    header .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    header a {
        color: white;
        text-decoration: none;
        font-size: 1.25rem;
        font-weight: bold;
    }

    header nav a {
        margin-left: 20px;
        color: white;
        text-decoration: none;
    }

    header nav a:hover {
        color: #ddd;
    }

    .head-cont a {
        color: #4CAF50;
        text-decoration: none;
    }

    footer {
        background-color: #333;
        color: white;
        text-align: center;
        padding: 20px;
    }
</style>
</html>
