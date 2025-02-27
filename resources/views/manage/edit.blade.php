@extends('layouts.video-manager')

@section('content')
    <div class="container">
        <h1>Editar Vídeo</h1>

        @can('manage_videos')
            <form action="{{ route('videos.update', $video->id) }}" method="POST" data-qa="form-edit-video">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Títol</label>
                    <input type="text" name="title" class="form-control" value="{{ $video->title }}" required data-qa="input-edit-video-title">
                </div>
                <button type="submit" class="btn btn-primary mt-3" data-qa="btn-submit-edit-video">Actualitzar</button>
            </form>
        @else
            <p>No tens permís per editar aquest vídeo.</p>
        @endcan

        <h2 class="mt-4">Llista de Vídeos</h2>
        <table class="table" data-qa="videos-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Títol</th>
                <th>Accions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($videos as $video)
                <tr>
                    <td data-qa="video-id">{{ $video->id }}</td>
                    <td data-qa="video-title">{{ $video->title }}</td>
                    <td>
                        @can('manage_videos')
                            <a href="{{ route('videos.edit', $video->id) }}" class="btn btn-sm btn-warning" data-qa="btn-edit-video">Editar</a>
                            <a href="{{ route('videos.delete', $video->id) }}" class="btn btn-sm btn-danger" data-qa="btn-delete-video">Eliminar</a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
