<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalls del Vídeo</title>
</head>
<body>
<main>
    {{ $slot }}
</main>
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
</style>
</html>
