@extends('layouts.manager-layout')

@section('content')
    @can('manage-series')
        <h1>Gestió de Sèries</h1>
        <a href="{{ route('series.manage.create') }}" class="btn btn-primary mb-3" data-qa="btn-add-series">Afegir nova sèrie</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Títol</th>
                <th>Descripció</th>
                <th>Publicat</th>
                <th>Accions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($series as $serie)
                <tr>
                    <td>{{ $serie->title }}</td>
                    <td>{{ $serie->description }}</td>
                    <td>{{ $serie->formatted_created_at }}</td>
                    <td>
                        <a href="{{ route('series.manage.edit', $serie->id) }}" class="btn btn-warning btn-sm" data-qa="btn-edit-series">Editar</a>
                        <a href="{{ route('series.manage.delete', $serie->id) }}" class="btn btn-danger btn-sm" data-qa="btn-delete-series">Eliminar</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>No tens permís per gestionar les sèries.</p>
    @endcan
@endsection
