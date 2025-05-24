@extends('layouts.manager-layout')

@section('title', 'Editar Sèrie')

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
                <li class="breadcrumb-item active" aria-current="page">Editar Sèrie</li>
            </ol>
        </nav>

        @can('manage-series')
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="page-title">
                        <i class="bi bi-pencil-square me-2"></i>
                        Editar Sèrie
                    </h1>
                    <p class="text-muted">Modifica la informació de "{{ Str::limit($series->title, 50) }}"</p>
                </div>

                <div class="d-flex gap-2">
                    <x-button
                        href="{{ route('series.show', $series->id) }}"
                        variant="outline"
                        icon="eye">
                        Veure Sèrie
                    </x-button>
                    <x-button
                        href="{{ route('series.manage.index') }}"
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
                                <i class="bi bi-collection-play me-2"></i>
                                Informació de la Sèrie
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

                        <form action="{{ route('series.manage.update', $series->id) }}" method="POST" enctype="multipart/form-data" data-qa="form-edit-series">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Títol -->
                                    <div class="form-group mb-3">
                                        <label for="title" class="form-label required">
                                            <i class="bi bi-type me-1"></i>Títol de la Sèrie
                                        </label>
                                        <input
                                            type="text"
                                            name="title"
                                            id="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title', $series->title) }}"
                                            required
                                            data-qa="input-title"
                                            placeholder="Introdueix el títol de la sèrie">
                                        @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Descripció -->
                                    <div class="form-group mb-3">
                                        <label for="description" class="form-label">
                                            <i class="bi bi-text-paragraph me-1"></i>Descripció
                                        </label>
                                        <textarea
                                            name="description"
                                            id="description"
                                            class="form-control @error('description') is-invalid @enderror"
                                            rows="4"
                                            data-qa="input-description"
                                            placeholder="Descripció de la sèrie (opcional)">{{ old('description', $series->description) }}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Estadístiques -->
                                    <div class="series-stats">
                                        <h6><i class="bi bi-bar-chart me-1"></i>Estadístiques</h6>
                                        <div class="stats-grid">
                                            <div class="stat-item">
                                                <span class="stat-label">Vídeos assignats:</span>
                                                <span class="stat-value">{{ $series->videos->count() }}</span>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-label">Creada:</span>
                                                <span class="stat-value">{{ $series->created_at->format('d/m/Y') }}</span>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-label">Actualitzada:</span>
                                                <span class="stat-value">{{ $series->updated_at->format('d/m/Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <!-- Imatge actual -->
                                    <div class="current-image mb-3">
                                        <h6><i class="bi bi-image me-1"></i>Imatge Actual</h6>
                                        @if($series->image)
                                            <img src="{{ asset('storage/series/' . $series->image) }}"
                                                 alt="{{ $series->title }}"
                                                 class="img-fluid rounded current-series-image">
                                        @else
                                            <div class="no-image-placeholder">
                                                <i class="bi bi-image"></i>
                                                <span>Sense imatge</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Canviar imatge -->
                                    <div class="form-group mb-3">
                                        <label for="image" class="form-label">
                                            <i class="bi bi-arrow-repeat me-1"></i>Canviar Imatge
                                        </label>
                                        <input
                                            type="file"
                                            name="image"
                                            id="image"
                                            class="form-control @error('image') is-invalid @enderror"
                                            accept="image/*"
                                            data-qa="input-image">
                                        @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Deixa buit per mantenir la imatge actual
                                        </div>
                                    </div>

                                    <!-- Vista prèvia de la nova imatge -->
                                    <div class="image-preview" id="imagePreview" style="display: none;">
                                        <h6><i class="bi bi-eye me-1"></i>Nova Imatge</h6>
                                        <img id="previewImg" src="/placeholder.svg" alt="Vista prèvia" class="img-fluid rounded">
                                    </div>
                                </div>
                            </div>

                            <!-- Botons d'acció -->
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <x-button
                                    href="{{ route('series.manage.index') }}"
                                    variant="outline"
                                    icon="x-circle"
                                    data-qa="cancel-button">
                                    Cancel·lar
                                </x-button>

                                <div class="d-flex gap-2">
                                    <x-button
                                        href="{{ route('series.manage.delete', $series->id) }}"
                                        variant="danger"
                                        icon="trash">
                                        Eliminar
                                    </x-button>
                                    <x-button
                                        type="submit"
                                        variant="primary"
                                        icon="check-circle"
                                        data-qa="btn-update-series">
                                        Actualitzar Sèrie
                                    </x-button>
                                </div>
                            </div>
                        </form>
                    </x-card>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-shield-exclamation text-warning" style="font-size: 3rem;"></i>
                <h3 class="mt-3">Accés Restringit</h3>
                <p class="text-muted">No tens permís per editar sèries.</p>
                <x-button href="{{ route('dashboard') }}" variant="primary" icon="house">
                    Tornar a l'Inici
                </x-button>
            </div>
        @endcan
    </div>

    <style>
        .current-series-image {
            max-height: 200px;
            width: 100%;
            object-fit: cover;
            border: 1px solid var(--color-gray-200);
        }

        .no-image-placeholder {
            height: 200px;
            background: var(--color-gray-100);
            border: 1px solid var(--color-gray-200);
            border-radius: var(--radius-md);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--color-gray-500);
        }

        .no-image-placeholder i {
            font-size: 2rem;
            margin-bottom: var(--spacing-sm);
        }

        .image-preview img {
            max-height: 200px;
            width: 100%;
            object-fit: cover;
            border: 1px solid var(--color-gray-200);
        }

        .series-stats {
            background: var(--color-gray-50);
            border-radius: var(--radius-md);
            padding: var(--spacing-md);
            margin-top: var(--spacing-lg);
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

        .required::after {
            content: " *";
            color: var(--color-danger);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');

            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.style.display = 'block';
                    };

                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                }
            });
        });
    </script>
@endsection
