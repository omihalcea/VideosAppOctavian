@extends('layouts.series-manager')

@section('content')
    <div class="container">
        <h1 class="mb-4">Sèries disponibles</h1>

        <form method="GET" action="{{ route('series.index') }}" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                   placeholder="Buscar sèries..." data-qa="input-search-series">
        </form>

        <div class="row">
            @forelse ($series as $serie)
                <div class="col-md-4 mb-4">
                    <div class="card h-100" data-qa="card-serie">
                        @if ($serie->image)
                            <img src="{{ asset('storage/series/' . $serie->image) }}" class="card-img-top"
                                 alt="{{ $serie->title }}" data-qa="card-serie-image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title" data-qa="card-serie-title">{{ $serie->title }}</h5>
                            <p class="card-text">{{ Str::limit($serie->description, 100) }}</p>
                            <a href="{{ route('series.show', $serie->id) }}" class="btn btn-primary"
                               data-qa="btn-view-serie">Veure vídeos</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">No s’han trobat sèries.</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $series->withQueryString()->links() }}
        </div>
    </div>
@endsection
