@extends('layouts.manager-layout')

@section('title', $video->title)

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
                @if($video->series)
                    <li class="breadcrumb-item">
                        <a href="{{ route('series.show', $video->series->id) }}" class="text-decoration-none">
                            {{ $video->series->title }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($video->title, 50) }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Columna principal del vídeo -->
            <div class="col-lg-8">
                <!-- Player de vídeo -->
                <div class="video-player-container mb-4">
                    <div class="ratio ratio-16x9">
                        <iframe
                            src="{{ $video->embed_url }}"
                            class="video-iframe"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>

                <!-- Informació del vídeo -->
                <div class="video-info-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <h1 class="video-title">{{ $video->title }}</h1>
                            <div class="video-meta">
                            <span class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                Publicat el {{ $video->formatted_published_at }}
                            </span>
                                @if($video->user)
                                    <span class="text-muted ms-3">
                                    <i class="bi bi-person me-1"></i>
                                    {{ $video->user->name }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Accions del vídeo -->
                        <div class="video-actions">
                            @can('manage-videos')
                                <x-button
{{--                                    href="{{ route('manage.edit', $video->id) }}"--}}
                                    variant="warning"
                                    size="sm"
                                    icon="pencil">
                                    Editar
                                </x-button>
                            @endcan

                            <x-button
                                href="{{ $video->url }}"
                                variant="outline"
                                size="sm"
                                icon="box-arrow-up-right"
                                target="_blank">
                                Veure Original
                            </x-button>
                        </div>
                    </div>

                    @if($video->description)
                        <div class="video-description">
                            <h5>Descripció</h5>
                            <p class="text-muted">{{ $video->description }}</p>
                        </div>
                    @endif
                </div>

                <!-- Navegació entre vídeos -->
                @if($video->previous_video || $video->next_video)
                    <div class="video-navigation">
                        <div class="row g-3">
                            <div class="col-6">
                                @if($video->previous_video)
                                    <a href="{{ route('videos.show', $video->previous_video->id) }}" class="nav-video-card prev">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-chevron-left me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">Anterior</small>
                                                <span class="fw-medium">{{ Str::limit($video->previous_video->title, 30) }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            </div>
                            <div class="col-6">
                                @if($video->next_video)
                                    <a href="{{ route('videos.show', $video->next_video->id) }}" class="nav-video-card next">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <div class="text-end">
                                                <small class="text-muted d-block">Següent</small>
                                                <span class="fw-medium">{{ Str::limit($video->next_video->title, 30) }}</span>
                                            </div>
                                            <i class="bi bi-chevron-right ms-2"></i>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                @if($video->series)
                    <!-- Informació de la sèrie -->
                    <div class="series-info-card mb-4">
                        <h5 class="d-flex align-items-center mb-3">
                            <i class="bi bi-collection-play me-2"></i>
                            Sèrie: {{ $video->series->title }}
                        </h5>

                        @if($video->series->image)
                            <img src="{{ asset('storage/series/' . $video->series->image) }}"
                                 alt="{{ $video->series->title }}"
                                 class="series-thumbnail mb-3">
                        @endif

                        @if($video->series->description)
                            <p class="text-muted small mb-3">{{ Str::limit($video->series->description, 120) }}</p>
                        @endif

                        <x-button
                            href="{{ route('series.show', $video->series->id) }}"
                            variant="primary"
                            size="sm"
                            icon="collection-play"
                            class="w-100">
                            Veure tots els vídeos
                        </x-button>
                    </div>
                @endif

                <!-- Estadístiques del vídeo -->
                <div class="video-stats-card">
                    <h5 class="mb-3">
                        <i class="bi bi-bar-chart me-2"></i>
                        Informació del vídeo
                    </h5>

                    <div class="stats-list">
                        <div class="stat-item">
                            <span class="stat-label">Data de creació:</span>
{{--                            <span class="stat-value">{{ $video->created_at->format('d/m/Y H:i') }}</span>--}}
                        </div>

{{--                        @if($video->formatted_published_at)--}}
{{--                            <div class="stat-item">--}}
{{--                                <span class="stat-label">Data de publicació:</span>--}}
{{--                                <span class="stat-value">{{ $video->formatted_published_at }}</span>--}}
{{--                            </div>--}}
{{--                        @endif--}}

                        @if($video->series)
                            <div class="stat-item">
                                <span class="stat-label">Sèrie:</span>
                                <span class="stat-value">{{ $video->series->title }}</span>
                            </div>
                        @endif

                        <div class="stat-item">
                            <span class="stat-label">Plataforma:</span>
                            <span class="stat-value">
                            @if($video->is_youtube)
                                    <i class="bi bi-youtube text-danger me-1"></i>YouTube
                                @else
                                    <i class="bi bi-play-circle me-1"></i>Altre
                                @endif
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        /* ===== ESTILS ESPECÍFICS PER A LA VISTA DE VÍDEO ===== */
        .video-player-container {
            background: var(--color-white);
            border-radius: var(--radius-lg);
            padding: var(--spacing-md);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--color-gray-200);
        }

        .video-iframe {
            border-radius: var(--radius-md);
            border: none;
        }

        .video-info-card {
            background: var(--color-white);
            border-radius: var(--radius-lg);
            padding: var(--spacing-xl);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--color-gray-200);
            margin-bottom: var(--spacing-xl);
        }

        .video-title {
            font-size: var(--font-size-2xl);
            font-weight: 700;
            color: var(--color-gray-900);
            margin-bottom: var(--spacing-sm);
            line-height: 1.3;
        }

        .video-meta {
            font-size: var(--font-size-sm);
            margin-bottom: var(--spacing-lg);
        }

        .video-actions {
            display: flex;
            gap: var(--spacing-sm);
            flex-wrap: wrap;
        }

        .video-description h5 {
            font-size: var(--font-size-lg);
            font-weight: 600;
            color: var(--color-gray-800);
            margin-bottom: var(--spacing-md);
        }

        .video-navigation {
            margin-top: var(--spacing-xl);
        }

        .nav-video-card {
            display: block;
            background: var(--color-white);
            border: 1px solid var(--color-gray-200);
            border-radius: var(--radius-md);
            padding: var(--spacing-md);
            text-decoration: none;
            color: var(--color-gray-800);
            transition: all var(--transition-fast);
            height: 100%;
        }

        .nav-video-card:hover {
            background: var(--color-gray-50);
            border-color: var(--color-primary);
            color: var(--color-primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .series-info-card,
        .video-stats-card {
            background: var(--color-white);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--color-gray-200);
            margin-bottom: var(--spacing-lg);
        }

        .series-thumbnail {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: var(--radius-md);
        }

        .stats-list {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-md);
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--spacing-sm) 0;
            border-bottom: 1px solid var(--color-gray-100);
        }

        .stat-item:last-child {
            border-bottom: none;
        }

        .stat-label {
            font-size: var(--font-size-sm);
            color: var(--color-gray-600);
            font-weight: 500;
        }

        .stat-value {
            font-size: var(--font-size-sm);
            color: var(--color-gray-800);
            font-weight: 600;
        }

        /* Breadcrumb personalitzat */
        .breadcrumb {
            background: var(--color-white);
            border-radius: var(--radius-md);
            padding: var(--spacing-md) var(--spacing-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--color-gray-200);
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            color: var(--color-gray-400);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .video-info-card {
                padding: var(--spacing-lg);
            }

            .video-title {
                font-size: var(--font-size-xl);
            }

            .video-actions {
                width: 100%;
                justify-content: stretch;
            }

            .video-actions .btn {
                flex: 1;
            }

            .nav-video-card {
                text-align: center;
            }

            .stat-item {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--spacing-xs);
            }
        }
    </style>
@endsection
