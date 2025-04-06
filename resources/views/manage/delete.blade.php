@extends('layouts.video-manager')

@section('content')
    <div class="container">
        <h1>Eliminar Vídeo</h1>

        @auth
            <p>Estàs segur que vols eliminar el vídeo: <strong data-qa="video-title">{{ $video->title }}</strong>?</p>

            <form action="{{ route('manage.destroy', $video->id) }}" method="POST" data-qa="form-delete-video">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" data-qa="btn-confirm-delete-video">Eliminar</button>
                <a href="{{ route('manage.index') }}" class="btn btn-secondary" data-qa="btn-cancel-delete-video">Cancel·lar</a>
            </form>
        @else
            <p>No tens permís per eliminar aquest vídeo.</p>
        @endauth
    </div>
@endsection
