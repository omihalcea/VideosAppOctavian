@extends('layouts.manager-layout')

@section('title', 'Gestió d\'Usuaris')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center content-spacing">
            <h1>Gestió d'Usuaris</h1>
            <x-button
                href="{{ route('users.create') }}"
                variant="success"
                icon="person-plus"
                data-qa="btn-create-user">
                Crear Usuari
            </x-button>
        </div>

        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped" data-qa="users-table">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Correu Electrònic</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Accions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="fw-medium">{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td>
                                @if($user->getRoleNames()->first())
                                    <span class="badge bg-primary">{{ $user->getRoleNames()->first() }}</span>
                                @else
                                    <span class="badge bg-secondary">Sense rol</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <x-button
                                        href="{{ route('users.show', $user->id) }}"
                                        variant="info"
                                        size="sm"
                                        icon="eye"
                                        data-qa="view-user-button">
                                        Veure
                                    </x-button>
                                    <x-button
                                        href="{{ route('users.edit', $user->id) }}"
                                        variant="warning"
                                        size="sm"
                                        icon="pencil"
                                        data-qa="edit-user-button">
                                        Editar
                                    </x-button>
                                    <x-button
                                        href="{{ route('users.delete', $user->id) }}"
                                        variant="danger"
                                        size="sm"
                                        icon="trash"
                                        data-qa="delete-user-button">
                                        Eliminar
                                    </x-button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginació si és necessària -->
            @if(method_exists($users, 'links'))
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links() }}
                </div>
            @endif
        @else
            <x-empty-state
                icon="people"
                title="No hi ha usuaris per gestionar"
                description="No hi ha usuaris disponibles per gestionar al sistema.">
                <x-slot name="action">
                    <x-button
                        href="{{ route('users.create') }}"
                        variant="success"
                        icon="person-plus">
                        Crear Primer Usuari
                    </x-button>
                </x-slot>
            </x-empty-state>
        @endif
    </div>
@endsection
