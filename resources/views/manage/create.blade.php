@extends('layouts.manager-layout')

@section('title', 'Afegir Nou Vídeo')

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
                <li class="breadcrumb-item active" aria-current="page">Afegir Vídeo</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="page-title">
                    <i class="bi bi-plus-circle me-2"></i>
                    Afegir Nou Vídeo
                </h1>
                <p class="text-muted">Crea un nou vídeo per a la plataforma</p>
            </div>

            <x-button
                href="{{ route('manage.index') }}"
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
                            <i class="bi bi-camera-video me-2"></i>
                            Informació del Vídeo
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

                    <form action="{{ route('manage.store') }}" method="POST" data-qa="form-create-video">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <!-- Títol -->
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label required">
                                        <i class="bi bi-type me-1"></i>Títol
                                    </label>
                                    <input
                                        type="text"
                                        name="title"
                                        id="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title') }}"
                                        required
                                        data-qa="input-video-title"
                                        placeholder="Introdueix el títol del vídeo">
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- URL -->
                                <div class="form-group mb-3">
                                    <label for="url" class="form-label required">
                                        <i class="bi bi-link-45deg me-1"></i>URL del Vídeo
                                    </label>
                                    <input
                                        type="url"
                                        name="url"
                                        id="url"
                                        class="form-control @error('url') is-invalid @enderror"
                                        value="{{ old('url') }}"
                                        required
                                        data-qa="input-video-url"
                                        placeholder="https://www.youtube.com/watch?v=...">
                                    @error('url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Suporta YouTube, Vimeo i altres plataformes
                                    </div>
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
                                        data-qa="input-video-description"
                                        placeholder="Descripció del vídeo (opcional)">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Sèrie -->
                                <div class="form-group mb-3">
                                    <label for="series_id" class="form-label">
                                        <i class="bi bi-collection-play me-1"></i>Sèrie
                                    </label>
                                    <select
                                        name="series_id"
                                        id="series_id"
                                        class="form-select @error('series_id') is-invalid @enderror">
                                        <option value="">Sense sèrie</option>
                                        @foreach(\App\Models\Series::all() as $series)
                                            <option value="{{ $series->id }}" {{ old('series_id') == $series->id ? 'selected' : '' }}>
                                                {{ $series->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('series_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Data de publicació -->
                                <div class="form-group mb-3">
                                    <label for="published_at" class="form-label">
                                        <i class="bi bi-calendar3 me-1"></i>Data de Publicació
                                    </label>
                                    <input
                                        type="datetime-local"
                                        name="published_at"
                                        id="published_at"
                                        class="form-control @error('published_at') is-invalid @enderror"
                                        value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                                    @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Deixa buit per publicar ara
                                    </div>
                                </div>

                                <!-- Vista prèvia -->
                                <div class="preview-container" style="display: none;">
                                    <h6><i class="bi bi-eye me-1"></i>Vista Prèvia</h6>
                                    <div class="video-preview">
                                        <img id="thumbnail-preview" src="/placeholder.svg" alt="Miniatura" class="img-fluid rounded">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botons d'acció -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <x-button
                                href="{{ route('manage.index') }}"
                                variant="outline"
                                icon="x-circle">
                                Cancel·lar
                            </x-button>

                            <div class="d-flex gap-2">
                                <x-button
                                    type="submit"
                                    variant="success"
                                    icon="check-circle"
                                    data-qa="btn-submit-create-video">
                                    Crear Vídeo
                                </x-button>
                            </div>
                        </div>
                    </form>
                </x-card>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlInput = document.getElementById('url');
            const previewContainer = document.querySelector('.preview-container');
            const thumbnailPreview = document.getElementById('thumbnail-preview');

            urlInput.addEventListener('blur', function() {
                const url = this.value;
                if (url && (url.includes('youtube.com') || url.includes('youtu.be'))) {
                    const videoId = extractYouTubeId(url);
                    if (videoId) {
                        thumbnailPreview.src = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
                        previewContainer.style.display = 'block';
                    }
                } else {
                    previewContainer.style.display = 'none';
                }
            });

            function extractYouTubeId(url) {
                const regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
                const matches = url.match(regex);
                return matches ? matches[1] : null;
            }
        });
    </script>
@endsection
