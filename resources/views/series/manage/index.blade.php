@extends('layouts.manager-layout')

@section('title', 'Gestió de Sèries')

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
                <li class="breadcrumb-item active" aria-current="page">Gestió de Sèries</li>
            </ol>
        </nav>

        @can('manage-series')
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="page-title">
                        <i class="bi bi-collection-play me-2"></i>
                        Gestió de Sèries
                    </h1>
                    <p class="text-muted">Organitza els vídeos en col·leccions temàtiques</p>
                </div>

                <x-button
                    href="{{ route('series.manage.create') }}"
                    variant="success"
                    icon="plus-circle"
                    data-qa="btn-add-series">
                    Nova Sèrie
                </x-button>
            </div>

            <!-- Estadístiques ràpides -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon bg-primary">
                            <i class="bi bi-collection-play"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $series->count() }}</h3>
                            <p>Total Sèries</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon bg-success">
                            <i class="bi bi-camera-video"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $series->sum(function($serie) { return $serie->videos->count(); }) }}</h3>
                            <p>Vídeos Assignats</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon bg-info">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $series->where('created_at', '>=', now()->subDays(30))->count() }}</h3>
                            <p>Noves (30d)</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($series->count() > 0)
                <!-- Vista en cards -->
                <div class="row">
                    @foreach($series as $serie)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="series-card">
                                <!-- Imatge de la sèrie -->
                                <div class="series-image">
                                    @if($serie->image)
                                        <img src="{{ asset('storage/series/' . $serie->image) }}"
                                             alt="{{ $serie->title }}"
                                             class="card-img-top">
                                    @else
                                        <div class="placeholder-image">
                                            <i class="bi bi-collection-play"></i>
                                            <span>Sense imatge</span>
                                        </div>
                                    @endif

                                    <!-- Badge amb número de vídeos -->
                                    <div class="video-count-badge">
                                        <i class="bi bi-camera-video me-1"></i>
                                        {{ $serie->videos->count() }} vídeos
                                    </div>
                                </div>

                                <!-- Contingut de la card -->
                                <div class="card-body">
                                    <h5 class="card-title">{{ $serie->title }}</h5>
                                    <p class="card-text text-muted">
                                        {{ Str::limit($serie->description, 100) ?: 'Sense descripció' }}
                                    </p>

                                    <!-- Metadades -->
                                    <div class="series-meta mb-3">
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            Creada el {{ $serie->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>

                                    <!-- Accions -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group" role="group">
                                            <x-button
                                                href="{{ route('series.show', $serie->id) }}"
                                                variant="info"
                                                size="sm"
                                                icon="eye"
                                                title="Veure sèrie">
                                            </x-button>
                                            <x-button
                                                href="{{ route('series.manage.edit', $serie->id) }}"
                                                variant="warning"
                                                size="sm"
                                                icon="pencil"
                                                data-qa="btn-edit-series"
                                                title="Editar sèrie">
                                            </x-button>
                                            <x-button
                                                href="{{ route('series.manage.delete', $serie->id) }}"
                                                variant="danger"
                                                size="sm"
                                                icon="trash"
                                                data-qa="btn-delete-series"
                                                title="Eliminar sèrie">
                                            </x-button>
                                        </div>

                                        @if($serie->videos->count() > 0)
                                            <small class="text-success">
                                                <i class="bi bi-check-circle-fill me-1"></i>Activa
                                            </small>
                                        @else
                                            <small class="text-warning">
                                                <i class="bi bi-exclamation-circle-fill me-1"></i>Buida
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <x-empty-state
                    icon="collection-play"
                    title="No hi ha sèries creades"
                    description="Crea la teva primera sèrie per organitzar els vídeos en col·leccions temàtiques.">
                    <x-slot name="action">
                        <x-button
                            href="{{ route('series.manage.create') }}"
                            variant="success"
                            icon="plus-circle">
                            Crear Primera Sèrie
                        </x-button>
                    </x-slot>
                </x-empty-state>
            @endif
        @else
            <div class="text-center py-5">
                <i class="bi bi-shield-exclamation text-warning" style="font-size: 3rem;"></i>
                <h3 class="mt-3">Accés Restringit</h3>
                <p class="text-muted">No tens permís per gestionar les sèries.</p>
                <x-button href="{{ route('dashboard') }}" variant="primary" icon="house">
                    Tornar a l'Inici
                </x-button>
            </div>
        @endcan
    </div>

    <style>
        /* Estadístiques */
        .stat-card {
            background: var(--color-white);
            border-radius: var(--radius-lg);
            padding: var(--spacing-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--color-gray-200);
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
            transition: all var(--transition-fast);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-content h3 {
            font-size: var(--font-size-2xl);
            font-weight: 700;
            margin: 0;
            color: var(--color-gray-900);
        }

        .stat-content p {
            font-size: var(--font-size-sm);
            color: var(--color-gray-600);
            margin: 0;
        }

        /* Cards de sèries */
        .series-card {
            background: var(--color-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--color-gray-200);
            overflow: hidden;
            transition: all var(--transition-fast);
            height: 100%;
        }

        .series-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .series-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .series-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-fast);
        }

        .series-card:hover .series-image img {
            transform: scale(1.05);
        }

        .placeholder-image {
            width: 100%;
            height: 100%;
            background: var(--color-gray-100);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--color-gray-500);
        }

        .placeholder-image i {
            font-size: 2rem;
            margin-bottom: var(--spacing-sm);
        }

        .video-count-badge {
            position: absolute;
            top: var(--spacing-sm);
            right: var(--spacing-sm);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 4px 8px;
            border-radius: var(--radius-sm);
            font-size: var(--font-size-xs);
            font-weight: 600;
        }

        .card-body {
            padding: var(--spacing-lg);
        }

        .card-title {
            font-size: var(--font-size-lg);
            font-weight: 600;
            color: var(--color-gray-900);
            margin-bottom: var(--spacing-sm);
        }

        .card-text {
            font-size: var(--font-size-sm);
            line-height: 1.5;
            margin-bottom: var(--spacing-md);
        }

        .series-meta {
            border-top: 1px solid var(--color-gray-100);
            padding-top: var(--spacing-sm);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stat-card {
                flex-direction: column;
                text-align: center;
            }

            .series-image {
                height: 150px;
            }
        }
    </style>
@endsection
