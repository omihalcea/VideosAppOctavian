@extends('layouts.user-manager')

@section('title', 'Eliminar Usuari')

@section('content')
    <h1>Eliminar Usuari</h1>

    <p>Estàs segur que vols eliminar l'usuari <strong>{{ $user->name }}</strong>?</p>
    <p>Un cop eliminat, aquesta acció no es podrà desfer.</p>

    <form action="{{ route('users.destroy', $user->id) }}" method="POST" data-qa="user-delete-form">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger" data-qa="delete-button">Eliminar Usuari</button>
        <a href="{{ route('users.manage.index') }}" class="btn btn-secondary" data-qa="cancel-button">Cancel·lar</a>
    </form>
@endsection
