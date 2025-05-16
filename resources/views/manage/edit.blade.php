@extends('layouts.video-manager')

@section('content')
    <div class="container">
        <h1>Editar Vídeo</h1>

        @can('manage-videos')
            <form action="{{ route('manage.update', $video->id) }}" method="POST" data-qa="form-edit-video">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Títol</label>
                    <input type="text" name="title" class="form-control" value="{{ $video->title }}" required data-qa="input-edit-video-title">
                </div>
                <div class="form-group">
                    <label for="description">Descripció</label>
                    <textarea name="description" class="form-control" required data-qa="input-edit-video-description">{{ $video->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="url">URL</label>
                    <input type="url" name="url" class="form-control" value="{{ $video->url }}" required data-qa="input-edit-video-url">
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
                <th>Miniatura</th>
                <th>Títol</th>
                <th>Accions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($videos as $v)
                <tr>
                    <td><img src="{{ $v->thumbnail_url }}" alt="{{ $v->title }}" class="img-thumbnail" width="100" data-qa="video-thumbnail"></td>
                    <td data-qa="video-title">{{ $v->title }}</td>
                    <td>
                        @can('manage_videos')
                            <a href="{{ route('manage.edit', $v->id) }}" class="btn btn-sm btn-warning" data-qa="btn-edit-video">Editar</a>
                            <a href="{{ route('manage.delete', $video->id) }}" class="btn btn-danger btn-sm" data-qa="btn-delete-video">Eliminar</a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
