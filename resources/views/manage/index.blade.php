@extends('layouts.manager-layout')

@section('title', 'Gestió de Vídeos')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center content-spacing">
            <h1>Gestió de Vídeos</h1>
            <x-button
                href="{{ route('manage.create') }}"
                variant="success"
                icon="plus-circle"
                data-qa="btn-add-video">
                Afegir Nou Vídeo
            </x-button>
        </div>

        @if($videos->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Miniatura</th>
                        <th scope="col">Títol</th>
                        <th scope="col">Data de publicació</th>
                        <th scope="col">Accions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($videos as $video)
                        <tr>
                            <td>
                                <a href="{{ route('videos.show', $video->id) }}" data-qa="video-link">
                                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}"
                                         class="img-thumbnail" width="100" data-qa="video-thumbnail">
                                </a>
                            </td>
                            <td data-qa="video-title">{{ $video->title }}</td>
                            <td>{{ $video->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <x-button
                                        href="{{ route('manage.edit', $video->id) }}"
                                        variant="warning"
                                        size="sm"
                                        icon="pencil"
                                        data-qa="btn-edit-video">
                                        Editar
                                    </x-button>
                                    <x-button
                                        href="{{ route('manage.delete', $video->id) }}"
                                        variant="danger"
                                        size="sm"
                                        icon="trash"
                                        data-qa="btn-delete-video">
                                        Eliminar
                                    </x-button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-empty-state
                icon="camera-video"
                title="No hi ha vídeos per gestionar"
                description="No hi ha vídeos disponibles per gestionar.">
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
