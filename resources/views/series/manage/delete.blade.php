@extends('layouts.manager-layout')

@section('title', 'Eliminar Sèrie')

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
                    <a href="{{ route('series.manage.index') }}" class="text-decoration-none">Gestió de Sèries</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Eliminar Sèrie</li>
            </ol>
        </nav>

        @can('manage-series')
            <!-- Header -->
            <div class="text-center mb-4">
                <div class="alert-icon mb-3">
                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                </div>
                <h1 class="page-title text-danger">
                    Eliminar Sèrie
                </h1>
                <p class="text-muted">Aquesta acció afectarà els vídeos associats</p>
            </div>

            <!-- Confirmació -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <x-card>
                        <x-slot name="header">
                            <h5 class="mb-0 text-danger">
                                <i class="bi bi-collection-x me-2"></i>
                                Confirmació d'Eliminació
                            </h5>
                        </x-slot>

                        <!-- Informació de la sèrie -->
                        <div class="series-info-delete mb-4">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    @if($series->image)
                                        <img src="{{ asset('storage/series/' . $series->image) }}"
                                             alt="{{ $series->title }}"
                                             class="img-fluid rounded">
                                    @else
                                        <div class="placeholder-image">
                                            <i class="bi bi-collection-play"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-8">
                                    <h6 class="mb-2">{{ $series->title }}</h6>
                                    @if($series->description)
                                        <p class="text-muted small mb-2">{{ Str::limit($series->description, 100) }}</p>
                                    @endif
                                    <div class="series-meta">
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            Creada el {{ $series->created_at->format('d/m/Y') }}
                                        </small>
                                        <br>
                                        <small class="text-info">
                                            <i class="bi bi-camera-video me-1"></i>
                                            {{ $series->videos->count() }} vídeos associats
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Advertència -->
                        <div class="alert alert-warning">
                            <h6 class="alert-heading">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Què passarà amb els vídeos?
                            </h6>
                            <p class="mb-2">Aquesta sèrie té <strong>{{ $series->videos->count() }} vídeos</strong> associats. Pots triar què fer amb ells:</p>
                        </div>

                        <!-- Formulari de confirmació -->
                        <form action="{{ route('series.manage.destroy', $series->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <!-- Opcions per als vídeos -->
                            <div class="video-options mb-4">
                                <h6><i class="bi bi-camera-video me-1"></i>Opcions per als Vídeos</h6>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="video_action" id="keep_videos" value="keep" checked>
                                    <label class="form-check-label" for="keep_videos">
                                        <strong>Mantenir els vídeos</strong>
                                        <br>
                                        <small class="text-muted">Els vídeos quedaran sense sèrie assignada</small>
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="video_action" id="delete_videos" value="delete">
                                    <label class="form-check-label" for="delete_videos">
                                        <strong class="text-danger">Eliminar també els vídeos</strong>
                                        <br>
                                        <small class="text-muted">⚠️ Això eliminarà permanentment tots els vídeos de la sèrie</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Confirmació -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="confirm-delete" required>
                                <label class="form-check-label" for="confirm-delete">
                                    Confirmo que vull eliminar la sèrie "{{ $series->title }}"
                                </label>
                            </div>

                            <!-- Botons d'acció -->
                            <div class="d-flex justify-content-between align-items-center">
                                <x-button
                                    href="{{ route('series.manage.index') }}"
                                    variant="outline"
                                    icon="arrow-left">
                                    Cancel·lar
                                </x-button>

                                <x-button
                                    type="submit"
                                    variant="danger"
                                    icon="trash"
                                    id="delete-button"
                                    disabled>
                                    Eliminar Sèrie
                                </x-button>
                            </div>
                        </form>
                    </x-card>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-shield-exclamation text-warning" style="font-size: 3rem;"></i>
                <h3 class="mt-3">Accés Restringit</h3>
                <p class="text-muted">No tens permís per eliminar sèries.</p>
                <x-button href="{{ route('dashboard') }}" variant="primary" icon="house">
                    Tornar a l'Inici
                </x-button>
            </div>
        @endcan
    </div>

    <style>
        .series-info-delete {
            background: var(--color-gray-50);
            border-radius: var(--radius-md);
            padding: var(--spacing-lg);
            border: 1px solid var(--color-gray-200);
        }

        .placeholder-image {
            width: 100%;
            height: 80px;
            background: var(--color-gray-200);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-gray-500);
            font-size: 1.5rem;
        }

        .video-options {
            background: var(--color-gray-50);
            border-radius: var(--radius-md);
            padding: var(--spacing-md);
            border: 1px solid var(--color-gray-200);
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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmCheckbox = document.getElementById('confirm-delete');
            const deleteButton = document.getElementById('delete-button');

            if (confirmCheckbox && deleteButton) {
                confirmCheckbox.addEventListener('change', function() {
                    deleteButton.disabled = !this.checked;
                });
            }
        });
    </script>
@endsection
