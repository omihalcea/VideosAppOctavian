@extends('layouts.manager-layout')

@section('title', 'Llista de Vídeos')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center content-spacing">
            <h1>Tots els Vídeos</h1>
            <x-button
                href="{{ route('manage.create') }}"
                variant="success"
                icon="plus-circle"
                data-qa="btn-add-video">
                Afegir Nou Vídeo
            </x-button>
        </div>

        @if($videos->count() > 0)
            <div class="grid-container">
                @foreach($videos as $video)
                    <x-card
                        title="{{ $video->title }}"
                        subtitle="{{ $video->created_at->format('d/m/Y') }}"
                        image="{{ $video->thumbnail_url }}"
                        imageAlt="{{ $video->title }}"
                        href="{{ route('videos.show', $video->id) }}"
                        data-qa="card-video">

                        <p class="text-muted mb-0">Usuari: {{ $video->user_id }}</p>

                        <x-slot name="actions">
                            <x-button
                                href="{{ route('videos.show', $video->id) }}"
                                variant="primary"
                                size="sm"
                                icon="play-circle"
                                data-qa="btn-view-video">
                                Veure Vídeo
                            </x-button>
                        </x-slot>
                    </x-card>
                @endforeach
            </div>
        @else
            <x-empty-state
                icon="camera-video"
                title="No hi ha vídeos"
                description="No hi ha vídeos disponibles per mostrar.">
                <x-slot name="action">
                    <x-button
                        href="{{ route('manage.create') }}"
                        variant="success"
                        icon="plus-circle">
                        Afegir Primer Vídeo
                    </x-button>
                </x-slot>
            </x-empty-state>
        @endif
    </div>
@endsection
