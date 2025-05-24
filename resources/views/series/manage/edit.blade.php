@extends('layouts.manager-layout')

@section('content')
    @can('manage-series')
        <h1>Editar sèrie</h1>
        <form action="{{ route('series.manage.update', $series->id) }}" method="POST" enctype="multipart/form-data" data-qa="form-edit-series">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title">Títol</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $series->title }}" data-qa="input-title">
            </div>
            <div class="mb-3">
                <label for="description">Descripció</label>
                <textarea name="description" id="description" class="form-control" data-qa="input-description">{{ $series->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="image">Canviar imatge</label>
                <input type="file" name="image" id="image" class="form-control" data-qa="input-image">
            </div>
            <button type="submit" class="btn btn-success" data-qa="btn-update-series">Actualitzar</button>
            <a href="{{ route('series.manage.index') }}" class="btn btn-secondary" data-qa="cancel-button">Cancel·lar</a>
        </form>
    @else
        <p>No tens permís per editar sèries.</p>
    @endcan
@endsection
