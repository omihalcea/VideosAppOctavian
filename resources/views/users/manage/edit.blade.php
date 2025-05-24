@extends('layouts.manager-layout')

@section('title', 'Editar Usuari')

@section('content')
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none">
                        <i class="bi bi-house me-1"></i>Inici
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('users.manage.index') }}" class="text-decoration-none">Gestió d'Usuaris</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Editar Usuari</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="page-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Editar Usuari
                </h1>
                <p class="text-muted">Modifica la informació de "{{ $user->name }}"</p>
            </div>

            <div class="d-flex gap-2">
                <x-button
                    href="{{ route('users.show', $user->id) }}"
                    variant="outline"
                    icon="eye">
                    Veure Perfil
                </x-button>
                <x-button
                    href="{{ route('users.manage.index') }}"
                    variant="outline"
                    icon="arrow-left">
                    Tornar
                </x-button>
            </div>
        </div>

        <!-- Formulari -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <x-card>
                    <x-slot name="header">
                        <h5 class="mb-0">
                            <i class="bi bi-person-gear me-2"></i>
                            Informació de l'Usuari
                        </h5>
                    </x-slot>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6><i class="bi bi-exclamation-triangle me-2"></i>Hi ha errors al formulari:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.update', $user->id) }}" method="POST" data-qa="edit-user-form">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Perfil actual -->
                                <div class="current-profile mb-4">
                                    <h6><i class="bi bi-person-circle me-1"></i>Perfil Actual</h6>
                                    <div class="d-flex align-items-center p-3 bg-light rounded">
                                        <div class="user-avatar me-3">
                                            @if($user->avatar)
                                                <img src="{{ asset('storage/avatars/' . $user->avatar) }}"
                                                     alt="{{ $user->name }}"
                                                     class="rounded-circle">
                                            @else
                                                <div class="avatar-placeholder">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $user->name }}</div>
                                            <div class="text-muted">{{ $user->email }}</div>
                                            @if($user->getRoleNames()->first())
                                                <span class="badge bg-primary">{{ ucfirst($user->getRoleNames()->first()) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Nom -->
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label required" data-qa="name-label">
                                        <i class="bi bi-person me-1"></i>Nom Complet
                                    </label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}"
                                        required
                                        placeholder="Introdueix el nom complet">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label required" data-qa="email-label">
                                        <i class="bi bi-envelope me-1"></i>Correu Electrònic
                                    </label>
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}"
                                        required
                                        placeholder="usuari@exemple.com">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if(!$user->email_verified_at)
                                        <div class="form-text text-warning">
                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                            Aquest email no està verificat
                                        </div>
                                    @endif
                                </div>

                                <!-- Rol -->
                                <div class="form-group mb-3">
                                    <label for="role" class="form-label required" data-qa="role-label">
                                        <i class="bi bi-shield me-1"></i>Rol
                                    </label>
                                    <select
                                        name="role"
                                        id="role"
                                        class="form-select @error('role') is-invalid @enderror"
                                        data-qa="role-select"
                                        required>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}"
                                                {{ ($userRole === $role->name || old('role') === $role->name) ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Estadístiques de l'usuari -->
                                <div class="user-stats mb-4">
                                    <h6><i class="bi bi-bar-chart me-1"></i>Estadístiques</h6>
                                    <div class="stats-grid">
                                        <div class="stat-item">
                                            <span class="stat-label">Registrat:</span>
                                            <span class="stat-value">{{ $user->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-label">Última actualització:</span>
                                            <span class="stat-value">{{ $user->updated_at->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-label">Email verificat:</span>
                                            <span class="stat-value">
                                            @if($user->email_verified_at)
                                                    <span class="text-success">
                                                    <i class="bi bi-check-circle-fill"></i> Sí
                                                </span>
                                                @else
                                                    <span class="text-warning">
                                                    <i class="bi bi-clock-fill"></i> No
                                                </span>
                                                @endif
                                        </span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-label">Últim accés:</span>
                                            <span class="stat-value">
                                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Mai' }}
                                        </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Opcions d'administració -->
                                <div class="admin-options">
                                    <h6><i class="bi bi-gear me-1"></i>Opcions d'Administració</h6>

                                    @if(!$user->email_verified_at)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="verify_email" id="verify_email" value="1">
                                            <label class="form-check-label" for="verify_email">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Marcar email com verificat
                                            </label>
                                        </div>
                                    @endif

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="send_notification" id="send_notification" value="1" checked>
                                        <label class="form-check-label" for="send_notification">
                                            <i class="bi bi-bell me-1"></i>
                                            Notificar canvis a l'usuari
                                        </label>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="force_password_reset" id="force_password_reset" value="1">
                                        <label class="form-check-label" for="force_password_reset">
                                            <i class="bi bi-key me-1"></i>
                                            Forçar canvi de contrasenya
                                        </label>
                                    </div>
                                </div>

                                <!-- Accions ràpides -->
                                <div class="quick-actions">
                                    <h6><i class="bi bi-lightning me-1"></i>Accions Ràpides</h6>
                                    <div class="d-grid gap-2">
                                        @if(!$user->email_verified_at)
                                            <x-button variant="outline" size="sm" icon="envelope-check">
                                                Reenviar Verificació
                                            </x-button>
                                        @endif
                                        <x-button variant="outline" size="sm" icon="key">
                                            Restablir Contrasenya
                                        </x-button>
                                        @if($user->id !== auth()->id())
                                            <x-button variant="outline" size="sm" icon="person-x" class="text-warning">
                                                Suspendre Usuari
                                            </x-button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botons d'acció -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <x-button
                                href="{{ route('users.manage.index') }}"
                                variant="outline"
                                icon="x-circle"
                                data-qa="cancel-button">
                                Cancel·lar
                            </x-button>

                            <div class="d-flex gap-2">
                                @if($user->id !== auth()->id())
                                    <x-button
                                        href="{{ route('users.delete', $user->id) }}"
                                        variant="danger"
                                        icon="trash">
                                        Eliminar
                                    </x-button>
                                @endif
                                <x-button
                                    type="submit"
                                    variant="primary"
                                    icon="check-circle"
                                    data-qa="edit-user-submit">
                                    Guardar Canvis
                                </x-button>
                            </div>
                        </div>
                    </form>
                </x-card>
            </div>
        </div>
    </div>

    <style>
        .current-profile {
            border: 1px solid var(--color-gray-200);
            border-radius: var(--radius-md);
            padding: var(--spacing-md);
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            flex-shrink: 0;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 50px;
            height: 50px;
            background: var(--color-primary);
            color: white;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: var(--font-size-sm);
        }

        .user-stats, .admin-options, .quick-actions {
            background: var(--color-gray-50);
            border-radius: var(--radius-md);
            padding: var(--spacing-md);
            margin-bottom: var(--spacing-md);
        }

        .stats-grid {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-sm);
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: var(--font-size-sm);
        }

        .stat-label {
            color: var(--color-gray-600);
        }

        .stat-value {
            font-weight: 600;
            color: var(--color-gray-800);
        }

        .form-check {
            margin-bottom: var(--spacing-sm);
        }

        .required::after {
            content: " *";
            color: var(--color-danger);
        }
    </style>
@endsection
