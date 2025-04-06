@extends('layouts.series-manager')

@section('content')
    @can('manage-series')
        <h1>Crear nova sèrie</h1>
        <form action="{{ route('series.manage.store') }}" method="POST" enctype="multipart/form-data" data-qa="form-create-series">
            @csrf
            <div class="mb-3">
                <label for="title">Títol</label>
                <input type="text" name="title" id="title" class="form-control" data-qa="input-title">
            </div>
            <div class="mb-3">
                <label for="description">Descripció</label>
                <textarea name="description" id="description" class="form-control" data-qa="input-description"></textarea>
            </div>
            <div class="mb-3">
                <label for="image">Imatge</label>
                <input type="file" name="image" id="image" class="form-control" data-qa="input-image">
            </div>
            <button type="submit" class="btn btn-success" data-qa="btn-save-series">Desar</button>
        </form>
    @else
        <p>No tens permís per crear sèries.</p>
    @endcan
@endsection
