@extends('layouts.series-manager')

@section('content')
    <div class="container mt-4">

        <h1 class="mb-3" data-qa="series-title">{{ $series->title }}</h1>
        <p data-qa="series-description">{{ $series->description }}</p>

        <div class="mb-4">
            <img src="{{ asset('storage/series/' . $series->image) }}" class="card-img-top"
                 alt="{{ $series->title }}" data-qa="card-serie-image">
            <p class="mt-2 text-muted">
                Publicat per <strong>{{ $series->user_name }}</strong> el {{ $series->formatted_created_at }}
            </p>
        </div>

        <h3 class="mb-3">Vídeos d’aquesta sèrie</h3>

        @if($series->videos->count() > 0)
            <div class="row">
                @foreach ($series->videos as $video)
                    <div class="col-md-4 mb-4" data-qa="video-card">
                        <div class="card h-100">
                            <iframe class="card-img-top" height="200" src="{{ $video->url }}" frameborder="0" allowfullscreen></iframe>
                            <div class="card-body">
                                <h5 class="card-title" data-qa="video-title">{{ $video->title }}</h5>
                                <p class="card-text">{{ Str::limit($video->description, 100) }}</p>
                                <p class="text-muted">{{ $video->formatted_for_humans_created_at }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Aquesta sèrie encara no té cap vídeo.</p>
        @endif

        <a href="{{ route('series.index') }}" class="btn btn-secondary mt-4" data-qa="btn-back">Tornar a totes les sèries</a>

    </div>
@endsection
