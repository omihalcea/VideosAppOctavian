@extends('layouts.video-manager')

@section('title', 'Gestió de Vídeos')

@section('content')
    <div class="container">
        <h1 class="mb-4">Gestió de Vídeos</h1>

        <div class="mb-3">
            <a href="{{ route('manage.create') }}" class="btn btn-success" data-qa="btn-add-video">Afegir Nou Vídeo</a>
        </div>

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
                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="img-thumbnail" width="100" data-qa="video-thumbnail">
                        </a>
                    </td>
                    <td data-qa="video-title">{{ $video->title }}</td>
                    <td>{{ $video->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('manage.edit', $video->id) }}" class="btn btn-warning btn-sm" data-qa="btn-edit-video">Editar</a>
                        <a href="{{ route('manage.delete', $video->id) }}" class="btn btn-danger btn-sm" data-qa="btn-delete-video">Eliminar</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if($videos->isEmpty())
            <p class="text-center text-muted mt-4">No hi ha vídeos disponibles.</p>
        @endif
    </div>
@endsection
