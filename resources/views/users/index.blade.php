@extends('layouts.manager-layout')

@section('title', 'Gestió d\'Usuaris')

@section('content')
    <div class="container">
        <h1>Llistat d'Usuaris</h1>

        <!-- Formulari de cerca -->
        <form method="GET" action="{{ route('users.index') }}" class="content-spacing">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Cerca per nom o correu" value="{{ request('search') }}">
                <x-button type="submit" variant="primary" icon="search">Cercar</x-button>
            </div>
        </form>

        @if($users->count() > 0)
            <div class="grid-container">
                @foreach ($users as $user)
                    <x-card
                        title="{{ $user->name }}"
                        subtitle="{{ $user->email }}"
                        data-qa="card-user">

                        <p class="text-muted mb-0">ID: {{ $user->id }}</p>

                        <x-slot name="actions">
                            <x-button
                                href="{{ route('users.show', $user->id) }}"
                                variant="info"
                                size="sm"
                                icon="play-circle"
                                data-qa="btn-view-user">
                                Veure Vídeos
                            </x-button>
                        </x-slot>
                    </x-card>
                @endforeach
            </div>

            <!-- Paginació -->
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
        @else
            <x-empty-state
                icon="people"
                title="No hi ha usuaris"
                description="No s'han trobat usuaris que coincideixin amb la cerca.">
                <x-slot name="action">
                    <x-button href="{{ route('users.index') }}" variant="primary" icon="arrow-clockwise">
                        Tornar a carregar
                    </x-button>
                </x-slot>
            </x-empty-state>
        @endif
    </div>
@endsection
