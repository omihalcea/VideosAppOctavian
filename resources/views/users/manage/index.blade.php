@extends('layouts.user-manager')

@section('title', 'Llista d\'Usuaris')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-4xl font-bold text-gray-800">Llista d'Usuaris</h1>
        <a href="{{ route('users.create') }}" class="btn btn-info">
            + Crear Usuari
        </a>
    </div>

    <table class="table table-striped" data-qa="users-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Correu Electrònic</th>
            <th>Rol</th>
            <th>Accions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->getRoleNames()->first() ?? 'Sense rol' }}</td>
                <td>
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info" data-qa="view-user-button">Veure</a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning" data-qa="edit-user-button">Editar</a>
                    <a href="{{ route('users.delete', $user->id) }}" class="btn btn-danger" data-qa="delete-user-button">Eliminar</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
