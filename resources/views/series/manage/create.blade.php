@extends('layouts.manager-layout')

@section('title', 'Crear Nova Sèrie')

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
                <li class="breadcrumb-item active" aria-current="page">Crear Sèrie</li>
            </ol>
        </nav>

        @auth
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="page-title">
                        <i class="bi bi-plus-circle me-2"></i>
                        Crear Nova Sèrie
                    </h1>
                    <p class="text-muted">Organitza els vídeos en una nova col·lecció temàtica</p>
                </div>

                <x-button
                    href="{{ route('series.manage.index') }}"
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

                        <form action="{{ route('series.manage.store') }}" method="POST" enctype="multipart/form-data" data-qa="form-create-series">
                            @csrf

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
                                            value="{{ old('title') }}"
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
                                            placeholder="Descripció de la sèrie (opcional)">{{ old('description') }}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Vídeos -->
                                    @if($videos->isEmpty())
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle me-2"></i>
                                            No hi ha vídeos disponibles per assignar. Pots afegir vídeos més tard.
                                        </div>
                                    @else
                                        <div class="form-group mb-3">
                                            <label for="videos" class="form-label">
                                                <i class="bi bi-camera-video me-1"></i>Vídeos sense sèrie
                                            </label>
                                            <select
                                                name="videos[]"
                                                id="videos"
                                                multiple
                                                class="form-select @error('videos') is-invalid @enderror"
                                                size="6">
                                                @foreach($videos as $video)
                                                    <option value="{{ $video->id }}" {{ in_array($video->id, old('videos', [])) ? 'selected' : '' }}>
                                                        {{ $video->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('videos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Mantén premut Ctrl (Cmd a Mac) per seleccionar múltiples vídeos
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <!-- Imatge -->
                                    <div class="form-group mb-3">
                                        <label for="image" class="form-label">
                                            <i class="bi bi-image me-1"></i>Imatge de la Sèrie
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
                                            Formats acceptats: JPG, PNG, GIF (màx. 2MB)
                                        </div>
                                    </div>

                                    <!-- Vista prèvia de la imatge -->
                                    <div class="image-preview" id="imagePreview" style="display: none;">
                                        <h6><i class="bi bi-eye me-1"></i>Vista Prèvia</h6>
                                        <img id="previewImg" src="/placeholder.svg" alt="Vista prèvia" class="img-fluid rounded">
                                    </div>

                                    <!-- Placeholder quan no hi ha imatge -->
                                    <div class="image-placeholder" id="imagePlaceholder">
                                        <i class="bi bi-image"></i>
                                        <span>Selecciona una imatge</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Botons d'acció -->
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <x-button
                                    href="{{ route('series.manage.index') }}"
                                    variant="outline"
                                    icon="x-circle">
                                    Cancel·lar
                                </x-button>

                                <x-button
                                    type="submit"
                                    variant="success"
                                    icon="check-circle"
                                    data-qa="btn-save-series">
                                    Crear Sèrie
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
                <p class="text-muted">No tens permís per crear sèries.</p>
                <x-button href="{{ route('dashboard') }}" variant="primary" icon="house">
                    Tornar a l'Inici
                </x-button>
            </div>
        @endauth
    </div>

    <style>
        .image-preview img {
            max-height: 200px;
            width: 100%;
            object-fit: cover;
            border: 1px solid var(--color-gray-200);
        }

        .image-placeholder {
            height: 200px;
            background: var(--color-gray-100);
            border: 2px dashed var(--color-gray-300);
            border-radius: var(--radius-md);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--color-gray-500);
            transition: all var(--transition-fast);
        }

        .image-placeholder:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .image-placeholder i {
            font-size: 2rem;
            margin-bottom: var(--spacing-sm);
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
            const imagePlaceholder = document.getElementById('imagePlaceholder');

            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.style.display = 'block';
                        imagePlaceholder.style.display = 'none';
                    };

                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                    imagePlaceholder.style.display = 'flex';
                }
            });
        });
    </script>
@endsection
