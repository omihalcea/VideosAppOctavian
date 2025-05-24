@extends('layouts.manager-layout')

@section('title', 'Editar Vídeo')

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
                <li class="breadcrumb-item active" aria-current="page">Editar Vídeo</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="page-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Editar Vídeo
                </h1>
                <p class="text-muted">Modifica la informació del vídeo "{{ Str::limit($video->title, 50) }}"</p>
            </div>

            <div class="d-flex gap-2">
                <x-button
                    href="{{ route('videos.show', $video->id) }}"
                    variant="outline"
                    icon="eye">
                    Veure
                </x-button>
                <x-button
                    href="{{ route('manage.index') }}"
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

                    <form action="{{ route('manage.update', $video->id) }}" method="POST" data-qa="form-edit-video">
                        @csrf
                        @method('PUT')

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
                                        value="{{ old('title', $video->title) }}"
                                        required
                                        data-qa="input-edit-video-title"
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
                                        value="{{ old('url', $video->url) }}"
                                        required
                                        data-qa="input-edit-video-url"
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
                                        data-qa="input-edit-video-description"
                                        placeholder="Descripció del vídeo (opcional)">{{ old('description', $video->description) }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Vista prèvia actual -->
                                <div class="current-video mb-3">
                                    <h6><i class="bi bi-eye me-1"></i>Vista Actual</h6>
                                    <div class="video-thumbnail">
                                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="img-fluid rounded">
                                        @if($video->is_youtube)
                                            <div class="platform-badge">
                                                <i class="bi bi-youtube text-danger"></i> YouTube
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Data de publicació -->
                                <div class="form-group mb-3">
                                    <label for="published_at" class="form-label">
                                        <i class="bi bi-calendar3 me-1"></i>Data de Publicació
                                    </label>
                                    @php
                                        $publishedValue = old('published_at');
                                        if (!$publishedValue && $video->published_at) {
                                            try {
                                                $publishedValue = \Carbon\Carbon::parse($video->published_at)->format('Y-m-d\TH:i');
                                            } catch (\Exception $e) {
                                                $publishedValue = '';
                                            }
                                        }
                                    @endphp
                                    <input
                                        type="datetime-local"
                                        name="published_at"
                                        id="published_at"
                                        class="form-control @error('published_at') is-invalid @enderror"
                                        value="{{ $publishedValue }}">
                                    @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Estadístiques -->
                                <div class="video-stats">
                                    <h6><i class="bi bi-bar-chart me-1"></i>Estadístiques</h6>
                                    <div class="stats-list">
                                        <div class="stat-item">
                                            <span class="stat-label">Creat:</span>
                                            <span class="stat-value">{{ $video->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-label">Actualitzat:</span>
                                            <span class="stat-value">{{ $video->updated_at->format('d/m/Y') }}</span>
                                        </div>
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
                                    href="{{ route('manage.delete', $video->id) }}"
                                    variant="danger"
                                    icon="trash">
                                    Eliminar
                                </x-button>
                                <x-button
                                    type="submit"
                                    variant="primary"
                                    icon="check-circle"
                                    data-qa="btn-submit-edit-video">
                                    Actualitzar Vídeo
                                </x-button>
                            </div>
                        </div>
                    </form>
                </x-card>
            </div>
        </div>
    </div>

    <style>
        .video-thumbnail {
            position: relative;
            border-radius: var(--radius-md);
            overflow: hidden;
        }

        .platform-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 4px 8px;
            border-radius: var(--radius-sm);
            font-size: var(--font-size-xs);
        }

        .video-stats {
            background: var(--color-gray-50);
            border-radius: var(--radius-md);
            padding: var(--spacing-md);
        }

        .stats-list {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-sm);
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            font-size: var(--font-size-sm);
        }

        .stat-label {
            color: var(--color-gray-600);
        }

        .stat-value {
            font-weight: 600;
            color: var(--color-gray-800);
        }
    </style>
@endsection
