@extends('layouts.manager-layout')

@section('title', 'Eliminar Usuari')

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
                <li class="breadcrumb-item active" aria-current="page">Eliminar Usuari</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="text-center mb-4">
            <div class="alert-icon mb-3">
                <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
            </div>
            <h1 class="page-title text-danger">
                Eliminar Usuari
            </h1>
            <p class="text-muted">Aquesta acció no es pot desfer i eliminarà totes les dades associades</p>
        </div>

        <!-- Confirmació -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <x-card>
                    <x-slot name="header">
                        <h5 class="mb-0 text-danger">
                            <i class="bi bi-person-x me-2"></i>
                            Confirmació d'Eliminació
                        </h5>
                    </x-slot>

                    <!-- Informació de l'usuari -->
                    <div class="user-info-delete mb-4">
                        <div class="d-flex align-items-center">
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
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $user->name }}</h6>
                                <p class="text-muted mb-1">{{ $user->email }}</p>
                                @if($user->getRoleNames()->first())
                                    <span class="badge bg-primary">{{ ucfirst($user->getRoleNames()->first()) }}</span>
                                @endif
                                <div class="user-meta mt-2">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        Registrat el {{ $user->created_at->format('d/m/Y') }}
                                    </small>
                                    @if($user->email_verified_at)
                                        <br>
                                        <small class="text-success">
                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            Email verificat
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Advertència crítica -->
                    <div class="alert alert-danger">
                        <h6 class="alert-heading">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Atenció! Acció Irreversible
                        </h6>
                        <p class="mb-2">Estàs a punt d'eliminar permanentment aquest usuari. Això comportarà:</p>
                        <ul class="mb-0">
                            <li><strong>Eliminació del compte</strong> i totes les dades personals</li>
                            <li><strong>Pèrdua de tots els continguts</strong> creats per aquest usuari</li>
                            <li><strong>Eliminació de l'historial</strong> d'activitat i sessions</li>
                            <li><strong>Impossibilitat de recuperar</strong> les dades eliminades</li>
                        </ul>
                    </div>

                    <!-- Verificació de seguretat -->
                    @if($user->id === auth()->id())
                        <div class="alert alert-warning">
                            <h6 class="alert-heading">
                                <i class="bi bi-shield-exclamation me-2"></i>
                                No pots eliminar el teu propi compte
                            </h6>
                            <p class="mb-0">Per seguretat, no pots eliminar el compte amb el qual estàs connectat actualment.</p>
                        </div>

                        <div class="text-center">
                            <x-button
                                href="{{ route('users.manage.index') }}"
                                variant="primary"
                                icon="arrow-left">
                                Tornar a la Gestió
                            </x-button>
                        </div>
                    @else
                        <!-- Formulari de confirmació -->
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" data-qa="user-delete-form">
                            @csrf
                            @method('DELETE')

                            <!-- Confirmació per escrit -->
                            <div class="form-group mb-3">
                                <label for="confirm-text" class="form-label required">
                                    <i class="bi bi-type me-1"></i>
                                    Per confirmar, escriu "<strong>{{ $user->name }}</strong>" al camp següent:
                                </label>
                                <input
                                    type="text"
                                    id="confirm-text"
                                    name="confirm_name"
                                    class="form-control"
                                    placeholder="Escriu el nom de l'usuari"
                                    required>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Aquesta verificació assegura que realment vols eliminar aquest usuari
                                </div>
                            </div>

                            <!-- Checkbox de confirmació -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="confirm-delete" required>
                                <label class="form-check-label" for="confirm-delete">
                                    <strong>Confirmo que vull eliminar aquest usuari permanentment</strong>
                                </label>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="understand-consequences" required>
                                <label class="form-check-label" for="understand-consequences">
                                    <strong>Entenc que aquesta acció no es pot desfer</strong>
                                </label>
                            </div>

                            <!-- Botons d'acció -->
                            <div class="d-flex justify-content-between align-items-center">
                                <x-button
                                    href="{{ route('users.manage.index') }}"
                                    variant="outline"
                                    icon="arrow-left"
                                    data-qa="cancel-button">
                                    Cancel·lar
                                </x-button>

                                <x-button
                                    type="submit"
                                    variant="danger"
                                    icon="person-x"
                                    id="delete-button"
                                    disabled
                                    data-qa="delete-button">
                                    Eliminar Usuari Definitivament
                                </x-button>
                            </div>
                        </form>
                    @endif
                </x-card>
            </div>
        </div>
    </div>

    <style>
        .user-info-delete {
            background: var(--color-gray-50);
            border-radius: var(--radius-md);
            padding: var(--spacing-lg);
            border: 1px solid var(--color-gray-200);
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            flex-shrink: 0;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 60px;
            height: 60px;
            background: var(--color-primary);
            color: white;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: var(--font-size-lg);
        }

        .alert-icon {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .form-check-input:checked {
            background-color: var(--color-danger);
            border-color: var(--color-danger);
        }

        #delete-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .required::after {
            content: " *";
            color: var(--color-danger);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmText = document.getElementById('confirm-text');
            const confirmDelete = document.getElementById('confirm-delete');
            const understandConsequences = document.getElementById('understand-consequences');
            const deleteButton = document.getElementById('delete-button');
            const expectedName = '{{ $user->name }}';

            function checkFormValidity() {
                const nameMatches = confirmText.value.trim() === expectedName;
                const deleteChecked = confirmDelete.checked;
                const consequencesChecked = understandConsequences.checked;

                deleteButton.disabled = !(nameMatches && deleteChecked && consequencesChecked);

                // Feedback visual per al camp de text
                if (confirmText.value.trim() && !nameMatches) {
                    confirmText.classList.add('is-invalid');
                } else {
                    confirmText.classList.remove('is-invalid');
                }
            }

            if (confirmText && confirmDelete && understandConsequences && deleteButton) {
                confirmText.addEventListener('input', checkFormValidity);
                confirmDelete.addEventListener('change', checkFormValidity);
                understandConsequences.addEventListener('change', checkFormValidity);
            }
        });
    </script>
@endsection
