@extends('layouts.manager-layout')

@section('title', 'Crear Usuari')

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
                <li class="breadcrumb-item active" aria-current="page">Crear Usuari</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="page-title">
                    <i class="bi bi-person-plus me-2"></i>
                    Crear Nou Usuari
                </h1>
                <p class="text-muted">Afegeix un nou usuari al sistema</p>
            </div>

            <x-button
                href="{{ route('users.manage.index') }}"
                variant="outline"
                icon="arrow-left">
                Tornar
            </x-button>
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

                    <form action="{{ route('users.store') }}" method="POST" data-qa="create-user-form">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
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
                                        value="{{ old('name') }}"
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
                                        value="{{ old('email') }}"
                                        required
                                        placeholder="usuari@exemple.com">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                        <option value="">Selecciona un rol</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        El rol determina els permisos de l'usuari
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Contrasenya -->
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label required" data-qa="password-label">
                                        <i class="bi bi-lock me-1"></i>Contrasenya
                                    </label>
                                    <div class="input-group">
                                        <input
                                            type="password"
                                            name="password"
                                            id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            required
                                            placeholder="Mínim 8 caràcters">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Mínim 8 caràcters, inclou majúscules, minúscules i números
                                    </div>
                                </div>

                                <!-- Confirmar Contrasenya -->
                                <div class="form-group mb-3">
                                    <label for="password_confirmation" class="form-label required" data-qa="password-confirm-label">
                                        <i class="bi bi-lock-fill me-1"></i>Confirmar Contrasenya
                                    </label>
                                    <div class="input-group">
                                        <input
                                            type="password"
                                            name="password_confirmation"
                                            id="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            required
                                            placeholder="Repeteix la contrasenya">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Opcions addicionals -->
                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="email_verified" id="email_verified" value="1" checked>
                                        <label class="form-check-label" for="email_verified">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Marcar email com verificat
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="send_welcome_email" id="send_welcome_email" value="1" checked>
                                        <label class="form-check-label" for="send_welcome_email">
                                            <i class="bi bi-envelope-heart me-1"></i>
                                            Enviar email de benvinguda
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vista prèvia del perfil -->
                        <div class="profile-preview mt-4 p-3 bg-light rounded">
                            <h6><i class="bi bi-eye me-1"></i>Vista Prèvia del Perfil</h6>
                            <div class="d-flex align-items-center">
                                <div class="avatar-preview me-3">
                                    <div class="avatar-placeholder-large" id="avatar-preview">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-medium" id="name-preview">Nom de l'usuari</div>
                                    <div class="text-muted" id="email-preview">email@exemple.com</div>
                                    <span class="badge bg-primary" id="role-preview">Rol</span>
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

                            <x-button
                                type="submit"
                                variant="success"
                                icon="check-circle"
                                data-qa="create-user-submit">
                                Crear Usuari
                            </x-button>
                        </div>
                    </form>
                </x-card>
            </div>
        </div>
    </div>

    <style>
        .avatar-placeholder-large {
            width: 60px;
            height: 60px;
            background: var(--color-primary);
            color: white;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .profile-preview {
            border: 1px solid var(--color-gray-200);
            transition: all var(--transition-fast);
        }

        .input-group .btn {
            border-left: none;
        }

        .form-check {
            margin-bottom: var(--spacing-sm);
        }

        .required::after {
            content: " *";
            color: var(--color-danger);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            document.getElementById('togglePassword').addEventListener('click', function() {
                const password = document.getElementById('password');
                const icon = this.querySelector('i');

                if (password.type === 'password') {
                    password.type = 'text';
                    icon.className = 'bi bi-eye-slash';
                } else {
                    password.type = 'password';
                    icon.className = 'bi bi-eye';
                }
            });

            document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
                const password = document.getElementById('password_confirmation');
                const icon = this.querySelector('i');

                if (password.type === 'password') {
                    password.type = 'text';
                    icon.className = 'bi bi-eye-slash';
                } else {
                    password.type = 'password';
                    icon.className = 'bi bi-eye';
                }
            });

            // Vista prèvia en temps real
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const roleSelect = document.getElementById('role');

            const namePreview = document.getElementById('name-preview');
            const emailPreview = document.getElementById('email-preview');
            const rolePreview = document.getElementById('role-preview');
            const avatarPreview = document.getElementById('avatar-preview');

            function updatePreview() {
                const name = nameInput.value || 'Nom de l\'usuari';
                const email = emailInput.value || 'email@exemple.com';
                const role = roleSelect.options[roleSelect.selectedIndex]?.text || 'Rol';

                namePreview.textContent = name;
                emailPreview.textContent = email;
                rolePreview.textContent = role;

                // Actualitzar avatar amb inicials
                if (nameInput.value) {
                    const initials = nameInput.value.split(' ').map(word => word[0]).join('').toUpperCase().substring(0, 2);
                    avatarPreview.textContent = initials;
                } else {
                    avatarPreview.innerHTML = '<i class="bi bi-person"></i>';
                }
            }

            nameInput.addEventListener('input', updatePreview);
            emailInput.addEventListener('input', updatePreview);
            roleSelect.addEventListener('change', updatePreview);
        });
    </script>
@endsection
