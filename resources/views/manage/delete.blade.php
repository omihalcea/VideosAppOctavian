@extends('layouts.manager-layout')

@section('title', 'Eliminar Vídeo')

@section('content')
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('videos.index') }}" class="text-decoration-none">
                        <i class="bi bi-house me-1"></i>Vídeos
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('manage.index') }}" class="text-decoration-none">Gestió</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Eliminar Vídeo</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="text-center mb-4">
            <div class="alert-icon mb-3">
                <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
            </div>
            <h1 class="page-title text-danger">
                Eliminar Vídeo
            </h1>
            <p class="text-muted">Aquesta acció no es pot desfer</p>
        </div>

        <!-- Confirmació -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <x-card>
                    <x-slot name="header">
                        <h5 class="mb-0 text-danger">
                            <i class="bi bi-trash me-2"></i>
                            Confirmació d'Eliminació
                        </h5>
                    </x-slot>

                    <!-- Informació del vídeo -->
                    <div class="video-info-delete mb-4">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <img src="{{ $video->thumbnail_url }}"
                                     alt="{{ $video->title }}"
                                     class="img-fluid rounded">
                            </div>
                            <div class="col-8">
                                <h6 class="mb-2" data-qa="video-title">{{ $video->title }}</h6>
                                @if($video->description)
                                    <p class="text-muted small mb-2">{{ Str::limit($video->description, 100) }}</p>
                                @endif
                                <div class="video-meta">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        Creat el {{ $video->created_at->format('d/m/Y') }}
                                    </small>
                                    @if($video->series)
                                        <br>
                                        <small class="text-muted">
                                            <i class="bi bi-collection-play me-1"></i>
                                            Sèrie: {{ $video->series->title }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Advertència -->
                    <div class="alert alert-danger">
                        <h6 class="alert-heading">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Atenció!
                        </h6>
                        <p class="mb-2">Estàs a punt d'eliminar permanentment aquest vídeo:</p>
                        <ul class="mb-0">
                            <li>Es perdran totes les dades associades</li>
                            <li>Els enllaços al vídeo deixaran de funcionar</li>
                            <li>Aquesta acció <strong>no es pot desfer</strong></li>
                        </ul>
                    </div>

                    <!-- Formulari de confirmació -->
                    @can('manage-videos')
                        <form action="{{ route('manage.destroy', $video->id) }}" method="POST" data-qa="form-delete-video">
                            @csrf
                            @method('DELETE')

                            <!-- Checkbox de confirmació -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="confirm-delete" required>
                                <label class="form-check-label" for="confirm-delete">
                                    Confirmo que vull eliminar aquest vídeo permanentment
                                </label>
                            </div>

                            <!-- Botons d'acció -->
                            <div class="d-flex justify-content-between align-items-center">
                                <x-button
                                    href="{{ route('manage.index') }}"
                                    variant="outline"
                                    icon="arrow-left"
                                    data-qa="btn-cancel-delete-video">
                                    Cancel·lar
                                </x-button>

                                <x-button
                                    type="submit"
                                    variant="danger"
                                    icon="trash"
                                    id="delete-button"
                                    disabled
                                    data-qa="btn-confirm-delete-video">
                                    Eliminar Definitivament
                                </x-button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            <i class="bi bi-shield-exclamation me-2"></i>
                            No tens permís per eliminar aquest vídeo.
                        </div>

                        <div class="text-center">
                            <x-button
                                href="{{ route('manage.index') }}"
                                variant="primary"
                                icon="arrow-left">
                                Tornar a la Gestió
                            </x-button>
                        </div>
                    @endcan
                </x-card>
            </div>
        </div>
    </div>

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

    <style>
        .video-info-delete {
            background: var(--color-gray-50);
            border-radius: var(--radius-md);
            padding: var(--spacing-lg);
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
@endsection
