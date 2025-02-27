@extends('layouts.video-manager')

@section('content')
    <div class="container">
        <h1>Afegir Nou Vídeo</h1>

        @can('manage_videos')
            <form action="{{ route('videos.store') }}" method="POST" data-qa="form-create-video">
                @csrf
                <div class="form-group">
                    <label for="title">Títol</label>
                    <input type="text" name="title" class="form-control" required data-qa="input-video-title">
                </div>
                <button type="submit" class="btn btn-success mt-3" data-qa="btn-submit-create-video">Guardar</button>
            </form>
        @else
            <p>No tens permís per afegir vídeos.</p>
        @endcan
    </div>
@endsection
