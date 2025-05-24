<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @auth
        <meta name="user-id" content="{{ auth()->id() }}">
    @endauth
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestió del Sistema')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <style>
        /* ===== VARIABLES CSS (PALETA DE COLORS I TIPOGRAFIA) ===== */
        :root {
            /* Colors primaris */
            --color-primary: #2563eb;
            --color-primary-hover: #1d4ed8;
            --color-primary-light: #dbeafe;

            /* Colors secundaris */
            --color-secondary: #64748b;
            --color-secondary-hover: #475569;
            --color-secondary-light: #f1f5f9;

            /* Colors d'estat */
            --color-success: #059669;
            --color-success-hover: #047857;
            --color-success-light: #d1fae5;

            --color-danger: #dc2626;
            --color-danger-hover: #b91c1c;
            --color-danger-light: #fee2e2;

            --color-warning: #d97706;
            --color-warning-hover: #b45309;
            --color-warning-light: #fef3c7;

            --color-info: #0891b2;
            --color-info-hover: #0e7490;
            --color-info-light: #cffafe;

            /* Colors neutres */
            --color-white: #ffffff;
            --color-gray-50: #f9fafb;
            --color-gray-100: #f3f4f6;
            --color-gray-200: #e5e7eb;
            --color-gray-300: #d1d5db;
            --color-gray-400: #9ca3af;
            --color-gray-500: #6b7280;
            --color-gray-600: #4b5563;
            --color-gray-700: #374151;
            --color-gray-800: #1f2937;
            --color-gray-900: #111827;

            /* Tipografia */
            --font-size-xs: 0.75rem;    /* 12px */
            --font-size-sm: 0.875rem;   /* 14px */
            --font-size-base: 1rem;     /* 16px */
            --font-size-lg: 1.125rem;   /* 18px */
            --font-size-xl: 1.25rem;    /* 20px */
            --font-size-2xl: 1.5rem;    /* 24px */
            --font-size-3xl: 1.875rem;  /* 30px */
            --font-size-4xl: 2.25rem;   /* 36px */

            /* Espaiat consistent */
            --spacing-xs: 0.25rem;   /* 4px */
            --spacing-sm: 0.5rem;    /* 8px */
            --spacing-md: 1rem;      /* 16px */
            --spacing-lg: 1.5rem;    /* 24px */
            --spacing-xl: 2rem;      /* 32px */
            --spacing-2xl: 3rem;     /* 48px */
            --spacing-3xl: 4rem;     /* 64px */

            /* Ombres */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);

            /* Radius */
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;

            /* Transicions */
            --transition-fast: 0.15s ease-in-out;
            --transition-normal: 0.3s ease-in-out;
        }

        /* ===== ESTILS GLOBALS ===== */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: var(--font-size-base);
            line-height: 1.6;
            color: var(--color-gray-800);
            background-color: var(--color-gray-50);
        }

        /* ===== COMPONENTS DE BOTONS ===== */
        .btn-primary-custom {
            background-color: var(--color-primary);
            color: var(--color-white);
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
        }

        .btn-primary-custom:hover {
            background-color: var(--color-primary-hover);
            color: var(--color-white);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-success-custom {
            background-color: var(--color-success);
            color: var(--color-white);
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
        }

        .btn-success-custom:hover {
            background-color: var(--color-success-hover);
            color: var(--color-white);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-danger-custom {
            background-color: var(--color-danger);
            color: var(--color-white);
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
        }

        .btn-danger-custom:hover {
            background-color: var(--color-danger-hover);
            color: var(--color-white);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-warning-custom {
            background-color: var(--color-warning);
            color: var(--color-white);
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
        }

        .btn-warning-custom:hover {
            background-color: var(--color-warning-hover);
            color: var(--color-white);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-info-custom {
            background-color: var(--color-info);
            color: var(--color-white);
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
        }

        .btn-info-custom:hover {
            background-color: var(--color-info-hover);
            color: var(--color-white);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-outline-custom {
            background-color: transparent;
            color: var(--color-primary);
            border: 2px solid var(--color-primary);
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
        }

        .btn-outline-custom:hover {
            background-color: var(--color-primary);
            color: var(--color-white);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* Mides dels botons */
        .btn-sm-custom {
            padding: var(--spacing-sm) var(--spacing-md);
            font-size: var(--font-size-sm);
        }

        .btn-md-custom {
            padding: var(--spacing-md) var(--spacing-lg);
            font-size: var(--font-size-base);
        }

        .btn-lg-custom {
            padding: var(--spacing-lg) var(--spacing-xl);
            font-size: var(--font-size-lg);
        }

        /* ===== COMPONENTS DE CARDS ===== */
        .card-custom {
            background-color: var(--color-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
            border: none;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-custom:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .card-image-container {
            position: relative;
            overflow: hidden;
        }

        .card-img-custom {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: transform var(--transition-normal);
        }

        .card-custom:hover .card-img-custom {
            transform: scale(1.05);
        }

        .card-body-custom {
            padding: var(--spacing-lg);
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-title-custom {
            font-size: var(--font-size-xl);
            font-weight: 600;
            color: var(--color-gray-900);
            margin-bottom: var(--spacing-sm);
            line-height: 1.4;
            min-height: 3rem;
        }

        .card-subtitle-custom {
            font-size: var(--font-size-sm);
            color: var(--color-gray-500);
            margin-bottom: var(--spacing-md);
        }

        .card-content-custom {
            flex-grow: 1;
            margin-bottom: var(--spacing-md);
        }

        .card-actions-custom {
            margin-top: auto;
            display: flex;
            gap: var(--spacing-sm);
            flex-wrap: wrap;
        }

        /* ===== COMPONENT D'ESTAT BUIT ===== */
        .empty-state-custom {
            text-align: center;
            padding: var(--spacing-3xl) var(--spacing-lg);
            color: var(--color-gray-500);
        }

        .empty-state-icon {
            font-size: var(--font-size-4xl);
            color: var(--color-gray-400);
            margin-bottom: var(--spacing-lg);
        }

        .empty-state-title {
            font-size: var(--font-size-2xl);
            font-weight: 600;
            color: var(--color-gray-700);
            margin-bottom: var(--spacing-md);
        }

        .empty-state-description {
            font-size: var(--font-size-base);
            margin-bottom: var(--spacing-xl);
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .empty-state-action {
            margin-top: var(--spacing-lg);
        }

        /* ===== GRID I ESPAIAT ===== */
        .grid-container {
            display: grid;
            gap: var(--spacing-lg);
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }

        .content-spacing {
            margin-bottom: var(--spacing-xl);
        }

        .section-spacing {
            margin-bottom: var(--spacing-2xl);
        }

        /* ===== TIPOGRAFIA ===== */
        h1 { font-size: var(--font-size-3xl); font-weight: 700; margin-bottom: var(--spacing-lg); }
        h2 { font-size: var(--font-size-2xl); font-weight: 600; margin-bottom: var(--spacing-md); }
        h3 { font-size: var(--font-size-xl); font-weight: 600; margin-bottom: var(--spacing-md); }
        h4 { font-size: var(--font-size-lg); font-weight: 600; margin-bottom: var(--spacing-sm); }
        h5 { font-size: var(--font-size-base); font-weight: 600; margin-bottom: var(--spacing-sm); }

        /* ===== NAVBAR PERSONALITZAT ===== */
        .navbar {
            background-color: var(--color-gray-900) !important;
            box-shadow: var(--shadow-md);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: var(--font-size-xl);
        }

        /* ===== FOOTER ===== */
        footer {
            margin-top: auto;
            background-color: var(--color-gray-900) !important;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .grid-container {
                grid-template-columns: 1fr;
                gap: var(--spacing-md);
            }

            .card-body-custom {
                padding: var(--spacing-md);
            }

            h1 { font-size: var(--font-size-2xl); }
            h2 { font-size: var(--font-size-xl); }
        }

        /* Superposició per a dropdowns i modals */
        .dropdown-backdrop {
            display: none !important;
            z-index: 0 !important;
        }

        .dropdown.show .dropdown-backdrop {
            display: block;
        }

        /* Millores per a mòbil */
        @media (max-width: 991.98px) {
            .navbar-nav {
                background-color: rgba(0, 0, 0, 0.1);
                border-radius: var(--radius-md);
                padding: var(--spacing-md);
                margin-top: var(--spacing-md);
            }

            .navbar-nav .nav-item {
                margin-bottom: var(--spacing-sm);
            }

            .dropdown-menu {
                position: static !important;
                transform: none !important;
                border: none;
                box-shadow: none;
                background-color: rgba(255, 255, 255, 0.1);
                margin-top: var(--spacing-sm);
            }

            .dropdown-item {
                color: rgba(255, 255, 255, 0.8) !important;
                padding: var(--spacing-sm) var(--spacing-md);
            }

            .dropdown-item:hover {
                background-color: rgba(255, 255, 255, 0.1);
                color: white !important;
            }
        }

        /* ===== ESTILS PER ALS TOASTS ===== */
        .toast-container {
            max-width: 400px;
            z-index: 1055;
        }

        .toast {
            min-width: 300px;
            box-shadow: var(--shadow-xl);
            border-radius: var(--radius-md);
            border: none;
        }

        .toast-body {
            font-size: var(--font-size-sm);
            font-weight: 500;
            padding: var(--spacing-md);
        }

        .toast.showing {
            animation: slideInRight 0.3s ease-out;
        }

        .toast.hide {
            animation: slideOutRight 0.3s ease-in;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('users.index') }}">
            <i class="bi bi-gear-fill me-2"></i>Sistema de Gestió
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link position-relative" href="{{ route('notifications.view') }}" title="Notificacions">
                        <i class="bi bi-bell-fill"></i>
                        <span class="visually-hidden">notificacions no llegides</span>
                    </a>
                </li>

                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-list-ul me-1"></i>Llistats
                        </a>
                        <div class="dropdown-backdrop"></div>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('users.index') }}">
                                    <i class="bi bi-people me-2"></i>Llistat d'Usuaris
                                </a></li>
                            <li><a class="dropdown-item" href="{{ route('videos.index') }}">
                                    <i class="bi bi-play-circle me-2"></i>Llistat de Vídeos
                                </a></li>
                            <li><a class="dropdown-item" href="{{ route('series.index') }}">
                                    <i class="bi bi-collection-play me-2"></i>Llistat de Sèries
                                </a></li>
                        </ul>
                    </li>
                @endauth

                @if(auth()->check() && (auth()->user()->can('manage-users') || auth()->user()->can('manage-videos') || auth()->user()->can('manage-series')))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-tools me-1"></i>Administració
                        </a>
                        <div class="dropdown-backdrop"></div>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="manageDropdown">
                            @can('manage-users')
                                <li><a class="dropdown-item" href="{{ route('users.manage.index') }}">
                                        <i class="bi bi-person-gear me-2"></i>Administrar Usuaris
                                    </a></li>
                            @endcan
                            @can('manage-videos')
                                <li><a class="dropdown-item" href="{{ route('manage.index') }}">
                                        <i class="bi bi-camera-video me-2"></i>Gestió de Vídeos
                                    </a></li>
                            @endcan
                            @can('manage-series')
                                <li><a class="dropdown-item" href="{{ route('series.manage.index') }}">
                                        <i class="bi bi-collection me-2"></i>Gestió de Sèries
                                    </a></li>
                            @endcan
                        </ul>
                    </li>
                @endif

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Iniciar Sessió
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-white p-0 border-0">
                                <i class="bi bi-box-arrow-right me-1"></i>Sortir
                            </button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4 flex-grow-1">
    @yield('content')
</main>

<footer class="bg-dark text-white text-center py-3 mt-4">
    &copy; {{ date('Y') }} Sistema de Gestió
</footer>

<!-- Container per als toasts -->
<div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3"></div>

<script>
    // ===== TOAST MANAGER =====
    class ToastManager {
        constructor() {
            this.container = document.getElementById('toast-container');
            this.toastCounter = 0;
        }

        show(message, type = 'success', duration = 5000) {
            const toastId = `toast-${++this.toastCounter}`;
            const iconClass = this.getIconClass(type);
            const bgClass = this.getBgClass(type);

            const toastHtml = `
                <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body d-flex align-items-center">
                            <i class="bi ${iconClass} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;

            this.container.insertAdjacentHTML('beforeend', toastHtml);

            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, {
                autohide: true,
                delay: duration
            });

            toast.show();

            // Eliminar l'element del DOM després que es tanqui
            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });

            return toast;
        }

        success(message, duration = 5000) {
            return this.show(message, 'success', duration);
        }

        error(message, duration = 7000) {
            return this.show(message, 'error', duration);
        }

        warning(message, duration = 6000) {
            return this.show(message, 'warning', duration);
        }

        info(message, duration = 5000) {
            return this.show(message, 'info', duration);
        }

        getIconClass(type) {
            const icons = {
                'success': 'bi-check-circle-fill',
                'error': 'bi-exclamation-triangle-fill',
                'warning': 'bi-exclamation-triangle-fill',
                'info': 'bi-info-circle-fill'
            };
            return icons[type] || icons['info'];
        }

        getBgClass(type) {
            const classes = {
                'success': 'bg-success',
                'error': 'bg-danger',
                'warning': 'bg-warning',
                'info': 'bg-info'
            };
            return classes[type] || classes['info'];
        }
    }

    // Instància global del ToastManager
    window.toastManager = new ToastManager();

    // Funcions globals per facilitar l'ús
    window.showToast = (message, type, duration) => window.toastManager.show(message, type, duration);
    window.showSuccess = (message, duration) => window.toastManager.success(message, duration);
    window.showError = (message, duration) => window.toastManager.error(message, duration);
    window.showWarning = (message, duration) => window.toastManager.warning(message, duration);
    window.showInfo = (message, duration) => window.toastManager.info(message, duration);

    document.addEventListener('DOMContentLoaded', function() {
        // ===== CONFIGURACIÓ DE PUSHER =====
        @if(env('PUSHER_APP_KEY'))
        const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });

        // Subscripció als canals
        const videosChannel = pusher.subscribe('videos');
        const seriesChannel = pusher.subscribe('series');
        const usersChannel = pusher.subscribe('users');

        // Events de vídeos
        videosChannel.bind('video.created', function(data) {
            showSuccess(`S'ha creat el vídeo "${data.video.title}"!`);
        });

        videosChannel.bind('video.updated', function(data) {
            showSuccess(`S'ha actualitzat el vídeo "${data.video.title}"!`);
        });

        videosChannel.bind('video.deleted', function(data) {
            showSuccess(`S'ha eliminat el vídeo "${data.video.title}"!`);
        });

        // Events de sèries
        seriesChannel.bind('series.created', function(data) {
            showSuccess(`S'ha creat la sèrie "${data.series.title}"!`);
        });

        seriesChannel.bind('series.updated', function(data) {
            showSuccess(`S'ha actualitzat la sèrie "${data.series.title}"!`);
        });

        seriesChannel.bind('series.deleted', function(data) {
            showSuccess(`S'ha eliminat la sèrie "${data.series.title}"!`);
        });

        // Events d'usuaris
        usersChannel.bind('user.created', function(data) {
            showSuccess(`S'ha creat l'usuari "${data.user.name}"!`);
        });

        usersChannel.bind('user.updated', function(data) {
            showSuccess(`S'ha actualitzat l'usuari "${data.user.name}"!`);
        });

        usersChannel.bind('user.deleted', function(data) {
            showSuccess(`S'ha eliminat l'usuari "${data.user.name}"!`);
        });
        @endif

        // ===== GESTIÓ DE DROPDOWNS (CODI ORIGINAL) =====
        const dropdowns = document.querySelectorAll('.dropdown');

        dropdowns.forEach(dropdown => {
            const backdrop = dropdown.querySelector('.dropdown-backdrop');

            dropdown.addEventListener('shown.bs.dropdown', function() {
                if (backdrop) {
                    backdrop.style.display = 'block';
                }
            });

            dropdown.addEventListener('hidden.bs.dropdown', function() {
                if (backdrop) {
                    backdrop.style.display = 'none';
                }
            });

            // Tancar dropdown quan es clica la superposició
            if (backdrop) {
                backdrop.addEventListener('click', function() {
                    const dropdownToggle = dropdown.querySelector('[data-bs-toggle="dropdown"]');
                    if (dropdownToggle) {
                        bootstrap.Dropdown.getInstance(dropdownToggle)?.hide();
                    }
                });
            }
        });

        // Tancar navbar en mòbil quan es clica un enllaç
        const navbarCollapse = document.getElementById('navbarNav');
        const navLinks = navbarCollapse.querySelectorAll('.nav-link:not(.dropdown-toggle)');

        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                }
            });
        });

        // ===== GESTIÓ DE SESSIONS DE LARAVEL =====
        @if(session('success'))
        showSuccess('{{ session('success') }}');
        @endif

        @if(session('error'))
        showError('{{ session('error') }}');
        @endif

        @if(session('warning'))
        showWarning('{{ session('warning') }}');
        @endif

        @if(session('info'))
        showInfo('{{ session('info') }}');
        @endif

        @if($errors->any())
        @foreach($errors->all() as $error)
        showError('{{ $error }}');
        @endforeach
        @endif
    });
</script>

@yield('scripts', '')
</body>
</html>
