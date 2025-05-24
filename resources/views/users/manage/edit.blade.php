@extends('layouts.manager-layout')

@section('title', 'Editar Usuari')

@section('content')
    <h1>Editar Usuari</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST" data-qa="edit-user-form">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label" data-qa="name-label">Nom</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label" data-qa="email-label">Correu Electrònic</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label" data-qa="role-label">Rol</label>
            <select name="role" id="role" class="form-control" data-qa="role-select">
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $userRole === $role->name ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary" data-qa="edit-user-submit">Guardar Canvis</button>
        <a href="{{ route('users.manage.index') }}" class="btn btn-secondary" data-qa="cancel-button">Cancel·lar</a>
    </form>
@endsection
