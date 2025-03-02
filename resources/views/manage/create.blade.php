@extends('layouts.video-manager')

@section('title', 'Afegir Nou Vídeo')

@section('content')
    <div class="container">
        <h1>Afegir Nou Vídeo</h1>

        @can('manage_videos')
            <form action="{{ route('manage.store') }}" method="POST" data-qa="form-create-video">
                @csrf

                <div class="form-group">
                    <label for="title">Títol</label>
                    <input type="text" name="title" class="form-control" required data-qa="input-video-title">
                </div>

                <div class="form-group">
                    <label for="description">Descripció</label>
                    <textarea name="description" class="form-control" required data-qa="input-video-description"></textarea>
                </div>

                <div class="form-group">
                    <label for="url">URL del Vídeo</label>
                    <input type="url" name="url" class="form-control" required data-qa="input-video-url">
                </div>

                <button type="submit" class="btn btn-success mt-3" data-qa="btn-submit-create-video">Guardar</button>
            </form>
        @else
            <p>No tens permís per afegir vídeos.</p>
        @endcan
    </div>
@endsection
