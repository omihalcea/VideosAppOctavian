<div>
    <body>
    {{-- VideosAppLayout --}}
    <div class="container">
        <div class="header">
            <h1>{{ $video->title }}</h1>
        </div>
        <div class="content">
            <p><strong>Descripció:</strong> {{ $video->description }}</p>
            <p><strong>URL:</strong> <a href="{{ $video->url }}" target="_blank">{{ $video->url }}</a></p>
            <iframe src="{{ $video->url }}" width="560" height="313" frameborder="0"></iframe>
            <p><strong>Publicat:</strong> {{ $video->formatted_published_at }}</p>
            <p><strong>Muntat:</strong> {{ $video->formatted_for_humans_published_at }}</p>
            <p><strong>ID Sèrie:</strong> {{ $video->series_id }}</p>

            <div class="links">
                @if ($video->previous)
                    <a href="{{ route('videos.show', $video->previous) }}">← Vídeo anterior</a>
                @else
                    <span></span>
                @endif
                @if ($video->next)
                    <a href="{{ route('videos.show', $video->next) }}">Vídeo següent →</a>
                @endif
            </div>
        </div>
    </div>
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
</div>
