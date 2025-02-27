@extends('layouts.video-manager')

@section('title', 'Llista de Vídeos')

@section('content')
    <div class="container">
        <h1 class="mb-4">Tots els Vídeos</h1>

        <div class="row">
            @foreach($videos as $video)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <a href="{{ route('videos.show', $video->id) }}" data-qa="video-link">
                            <img src="{{ $video->thumbnail_url }}" class="card-img-top" alt="{{ $video->title }}" data-qa="video-thumbnail">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title" data-qa="video-title">{{ $video->title }}</h5>
                            <p class="card-text text-muted">{{ $video->created_at->format('d/m/Y') }}</p>
                            <a href="{{ route('videos.show', $video->id) }}" class="btn btn-primary btn-sm" data-qa="btn-view-video">Veure Vídeo</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($videos->isEmpty())
            <p class="text-center text-muted mt-4">No hi ha vídeos disponibles.</p>
        @endif
    </div>
@endsection
