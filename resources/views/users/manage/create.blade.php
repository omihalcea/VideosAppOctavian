@extends('layouts.user-manager')

@section('title', 'Crear Usuari')

@section('content')
    <h1>Crear Nou Usuari</h1>

    <form action="{{ route('users.store') }}" method="POST" data-qa="create-user-form">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label" data-qa="name-label">Nom</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label" data-qa="email-label">Correu Electrònic</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label" data-qa="password-label">Contrasenya</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label" data-qa="password-confirm-label">Confirmar Contrasenya</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label" data-qa="role-label">Rol</label>
            <select name="role" id="role" class="form-control" data-qa="role-select">
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary" data-qa="create-user-submit">Crear Usuari</button>
        <a href="{{ route('users.manage.index') }}" class="btn btn-secondary" data-qa="cancel-button">Cancel·lar</a>
    </form>
@endsection
