@extends('layouts.series-manager')

@section('title', 'Confirmar Eliminació de la Sèrie')

@section('content')
    @can('manage-series')
        <h1>Confirmar Eliminació de la Sèrie</h1>
        <div class="container">
            <h1 class="mb-4">Confirmar Eliminació de la Sèrie</h1>

            <p>Estàs segur que vols eliminar la sèrie "<strong>{{ $series->title }}</strong>"?</p>

            <p>Aquesta acció també pot eliminar els vídeos associats a la sèrie. Si no vols eliminar els vídeos, només els desassignarem de la sèrie.</p>

            <form action="{{ route('series.manage.destroy', $series->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="delete_videos" value="yes" id="delete_videos">
                    <label class="form-check-label" for="delete_videos">Eliminar també els vídeos associats</label>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-danger">Eliminar Sèrie</button>
                    <a href="{{ route('series.manage.index') }}" class="btn btn-secondary">Cancel·lar</a>
                </div>
            </form>
        </div>
    @endcan
@endsection
