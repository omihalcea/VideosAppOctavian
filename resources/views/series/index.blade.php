@extends('layouts.manager-layout')

@section('title', 'Llista de Sèries')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center content-spacing">
            <h1>Sèries disponibles</h1>
            <x-button
                href="{{ route('series.manage.create') }}"
                variant="success"
                icon="plus-circle"
                data-qa="btn-add-series">
                Crear nova sèrie
            </x-button>
        </div>

        <!-- Formulari de cerca -->
        <form method="GET" action="{{ route('series.index') }}" class="content-spacing">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="Buscar sèries..."
                       data-qa="input-search-series">
                <x-button type="submit" variant="primary" icon="search">Cercar</x-button>
            </div>
        </form>

        @if($series->count() > 0)
            <div class="grid-container">
                @foreach ($series as $serie)
                    <x-card
                        title="{{ $serie->title }}"
                        image="{{ $serie->image ? asset('storage/series/' . $serie->image) : null }}"
                        imageAlt="{{ $serie->title }}"
                        data-qa="card-serie">

                        <p class="card-text">{{ Str::limit($serie->description, 100) }}</p>

                        <x-slot name="actions">
                            <x-button
                                href="{{ route('series.show', $serie->id) }}"
                                variant="primary"
                                size="sm"
                                icon="collection-play"
                                data-qa="btn-view-serie">
                                Veure vídeos
                            </x-button>
                        </x-slot>
                    </x-card>
                @endforeach
            </div>

            <!-- Paginació -->
            <div class="d-flex justify-content-center mt-4">
                {{ $series->withQueryString()->links() }}
            </div>
        @else
            <x-empty-state
                icon="collection-play"
                title="No hi ha sèries"
                description="No s'han trobat sèries que coincideixin amb la cerca.">
                <x-slot name="action">
                    <x-button
                        href="{{ route('series.manage.create') }}"
                        variant="success"
                        icon="plus-circle">
                        Crear Primera Sèrie
                    </x-button>
                </x-slot>
            </x-empty-state>
        @endif
    </div>
@endsection
