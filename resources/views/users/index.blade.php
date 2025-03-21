@extends('layouts.user-manager') <!-- Extensió del layout user-manager -->

@section('title', 'Gestió d\'Usuaris') <!-- Títol per la pàgina -->

@section('content') <!-- Contingut de la pàgina que es mostra dins del layout -->

<div class="container mt-4">
    <h1 class="mb-4">Llistat d'Usuaris</h1>

    <!-- Formulari de cerca -->
    <form method="GET" action="{{ route('users.index') }}" class="mb-4">
        <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Cerca per nom o correu" value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Cercar</button>
        </div>
    </form>

    <!-- Taula d'usuaris -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Correu electrònic</th>
            <th>Accions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">Videos</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No s'han trobat usuaris.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <!-- Paginació (si es fa servir paginació) -->
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>

@endsection
