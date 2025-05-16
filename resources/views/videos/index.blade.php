@extends('layouts.video-manager')

@section('title', 'Llista de Vídeos')

@section('content')
    <div class="container">

        <div class="mb-3">
            <a href="{{ route('manage.create') }}" class="btn btn-success" data-qa="btn-add-video">Afegir Nou Vídeo</a>
        </div>

        <h1 class="mb-4">Tots els Vídeos</h1>

        <div class="row">
            @foreach($videos as $video)
                <div class="col-md-4 mb-4">
                    <a href="{{ route('videos.show', $video->id) }}" data-qa="video-link">
                    <div class="card video-card">
                        <a href="{{ route('videos.show', $video->id) }}" data-qa="video-link">
                            <img src="{{ $video->thumbnail_url }}" class="card-img-top video-thumbnail" alt="{{ $video->title }}" data-qa="video-thumbnail">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title" data-qa="video-title">{{ $video->title }}</h5>
                            <p class="card-text text-muted">{{ $video->created_at->format('d/m/Y') }}</p>
                            <p>{{ $video->user_id }}</p>
                            <a href="{{ route('videos.show', $video->id) }}" class="btn btn-primary btn-sm" data-qa="btn-view-video">Veure Vídeo</a>
                        </div>
                    </div>
                    </a>
                </div>
            @endforeach
        </div>

        @if($videos->isEmpty())
            <p class="text-center text-muted mt-4">No hi ha vídeos disponibles.</p>
        @endif
    </div>
    <style>
        .video-card {
            display: flex;
            flex-direction: column;
            height: 100%; /* Assegura que totes les targetes tinguin la mateixa alçada */
        }

        .video-thumbnail {
            width: 100%;
            height: 220px; /* Ajusta l’altura per evitar franges negres */
            object-fit: cover; /* Retalla la imatge per omplir l’espai */
        }

        .card-body {
            flex-grow: 1; /* Fa que el contingut ocupi tot l'espai disponible */
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Distribueix l'espai uniformement */
        }

        .card-title {
            min-height: 40px; /* Estableix una altura mínima per evitar que targetes amb títols curts es vegin diferents */
        }
    </style>
@endsection
