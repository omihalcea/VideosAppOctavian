<x-videos-app-layout>
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
</x-videos-app-layout>
