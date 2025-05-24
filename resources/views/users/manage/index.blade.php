@extends('layouts.manager-layout')

@section('title', 'Gestió d\'Usuaris')

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
                <li class="breadcrumb-item active" aria-current="page">Gestió d'Usuaris</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="page-title">
                    <i class="bi bi-people me-2"></i>
                    Gestió d'Usuaris
                </h1>
                <p class="text-muted">Administra els usuaris del sistema</p>
            </div>

            <x-button
                href="{{ route('users.create') }}"
                variant="success"
                icon="person-plus"
                data-qa="btn-create-user">
                Crear Usuari
            </x-button>
        </div>

        <!-- Filtres i cerca -->
        <x-card class="mb-4">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label">
                        <i class="bi bi-search me-1"></i>Cercar usuaris
                    </label>
                    <input type="text" id="search" class="form-control" placeholder="Nom o email...">
                </div>
                <div class="col-md-3">
                    <label for="role-filter" class="form-label">
                        <i class="bi bi-funnel me-1"></i>Filtrar per rol
                    </label>
                    <select id="role-filter" class="form-select">
                        <option value="">Tots els rols</option>
                        <option value="admin">Administrador</option>
                        <option value="editor">Editor</option>
                        <option value="user">Usuari</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status-filter" class="form-label">
                        <i class="bi bi-toggle-on me-1"></i>Estat
                    </label>
                    <select id="status-filter" class="form-select">
                        <option value="">Tots</option>
                        <option value="active">Actius</option>
                        <option value="inactive">Inactius</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <x-button variant="outline" icon="arrow-clockwise" class="w-100">
                        Netejar
                    </x-button>
                </div>
            </div>
        </x-card>

        @if($users->count() > 0)
            <!-- Estadístiques ràpides -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon bg-primary">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $users->count() }}</h3>
                            <p>Total Usuaris</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon bg-success">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $users->whereNotNull('email_verified_at')->count() }}</h3>
                            <p>Verificats</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-person-gear"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $users->filter(function($user) { return $user->hasRole('admin'); })->count() }}</h3>
                            <p>Administradors</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon bg-info">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $users->where('created_at', '>=', now()->subDays(30))->count() }}</h3>
                            <p>Nous (30d)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Taula d'usuaris -->
            <x-card>
                <x-slot name="header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-table me-2"></i>
                            Llista d'Usuaris
                        </h5>
                        <div class="d-flex gap-2">
                            <x-button variant="outline" size="sm" icon="download">
                                Exportar
                            </x-button>
                            <x-button variant="outline" size="sm" icon="arrow-clockwise">
                                Actualitzar
                            </x-button>
                        </div>
                    </div>
                </x-slot>

                <div class="table-responsive">
                    <table class="table table-hover" data-qa="users-table">
                        <thead class="table-light">
                        <tr>
                            <th scope="col" class="sortable" data-sort="id">
                                <i class="bi bi-hash me-1"></i>ID
                                <i class="bi bi-chevron-expand sort-icon"></i>
                            </th>
                            <th scope="col" class="sortable" data-sort="name">
                                <i class="bi bi-person me-1"></i>Usuari
                                <i class="bi bi-chevron-expand sort-icon"></i>
                            </th>
                            <th scope="col" class="sortable" data-sort="email">
                                <i class="bi bi-envelope me-1"></i>Email
                                <i class="bi bi-chevron-expand sort-icon"></i>
                            </th>
                            <th scope="col">
                                <i class="bi bi-shield me-1"></i>Rol
                            </th>
                            <th scope="col">
                                <i class="bi bi-check-circle me-1"></i>Estat
                            </th>
                            <th scope="col" class="sortable" data-sort="created_at">
                                <i class="bi bi-calendar me-1"></i>Registre
                                <i class="bi bi-chevron-expand sort-icon"></i>
                            </th>
                            <th scope="col" class="text-center">
                                <i class="bi bi-gear me-1"></i>Accions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr class="user-row" data-user-id="{{ $user->id }}">
                                <td class="fw-medium text-primary">{{ $user->id }}</td>
                                <td>
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
                                        <div>
                                            <div class="fw-medium">{{ $user->name }}</div>
                                            <small class="text-muted">{{ '@' . Str::slug($user->name) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="text-muted">{{ $user->email }}</div>
                                        @if($user->email_verified_at)
                                            <small class="text-success">
                                                <i class="bi bi-check-circle-fill me-1"></i>Verificat
                                            </small>
                                        @else
                                            <small class="text-warning">
                                                <i class="bi bi-exclamation-circle-fill me-1"></i>Pendent
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($user->getRoleNames()->first())
                                        @php
                                            $role = $user->getRoleNames()->first();
                                            $badgeClass = match($role) {
                                                'admin' => 'bg-danger',
                                                'editor' => 'bg-warning',
                                                'moderator' => 'bg-info',
                                                default => 'bg-primary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            <i class="bi bi-shield-check me-1"></i>{{ ucfirst($role) }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-person me-1"></i>Sense rol
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="status-badge active">
                                            <i class="bi bi-check-circle-fill"></i> Actiu
                                        </span>
                                    @else
                                        <span class="status-badge inactive">
                                            <i class="bi bi-clock-fill"></i> Pendent
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-medium">{{ $user->created_at->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <x-button
                                            href="{{ route('users.show', $user->id) }}"
                                            variant="info"
                                            size="sm"
                                            icon="eye"
                                            data-qa="view-user-button"
                                            title="Veure usuari">
                                        </x-button>
                                        <x-button
                                            href="{{ route('users.edit', $user->id) }}"
                                            variant="warning"
                                            size="sm"
                                            icon="pencil"
                                            data-qa="edit-user-button"
                                            title="Editar usuari">
                                        </x-button>
                                        @if($user->id !== auth()->id())
                                            <x-button
                                                href="{{ route('users.delete', $user->id) }}"
                                                variant="danger"
                                                size="sm"
                                                icon="trash"
                                                data-qa="delete-user-button"
                                                title="Eliminar usuari">
                                            </x-button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginació -->
                @if(method_exists($users, 'links'))
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                @endif
            </x-card>
        @else
            <x-empty-state
                icon="people"
                title="No hi ha usuaris per gestionar"
                description="No hi ha usuaris disponibles per gestionar al sistema.">
                <x-slot name="action">
                    <x-button
                        href="{{ route('users.create') }}"
                        variant="success"
                        icon="person-plus">
                        Crear Primer Usuari
                    </x-button>
                </x-slot>
            </x-empty-state>
        @endif
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

        /* Avatar d'usuari */
        .user-avatar {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 40px;
            height: 40px;
            background: var(--color-primary);
            color: white;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: var(--font-size-sm);
        }

        /* Estats */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: var(--radius-sm);
            font-size: var(--font-size-xs);
            font-weight: 500;
        }

        .status-badge.active {
            background: var(--color-success-light);
            color: var(--color-success);
        }

        .status-badge.inactive {
            background: var(--color-warning-light);
            color: var(--color-warning);
        }

        /* Taula sortable */
        .sortable {
            cursor: pointer;
            user-select: none;
            position: relative;
        }

        .sortable:hover {
            background: var(--color-gray-100);
        }

        .sort-icon {
            font-size: 0.75rem;
            opacity: 0.5;
            margin-left: 4px;
        }

        .sortable.asc .sort-icon::before {
            content: "\F282";
        }

        .sortable.desc .sort-icon::before {
            content: "\F283";
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stat-card {
                flex-direction: column;
                text-align: center;
            }

            .user-avatar {
                width: 32px;
                height: 32px;
            }

            .avatar-placeholder {
                width: 32px;
                height: 32px;
                font-size: 0.75rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Funcionalitat de cerca
            const searchInput = document.getElementById('search');
            const roleFilter = document.getElementById('role-filter');
            const statusFilter = document.getElementById('status-filter');

            function filterUsers() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedRole = roleFilter.value.toLowerCase();
                const selectedStatus = statusFilter.value.toLowerCase();

                document.querySelectorAll('.user-row').forEach(row => {
                    const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                    const role = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                    const status = row.querySelector('.status-badge').textContent.toLowerCase();

                    const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                    const matchesRole = !selectedRole || role.includes(selectedRole);
                    const matchesStatus = !selectedStatus || status.includes(selectedStatus);

                    row.style.display = matchesSearch && matchesRole && matchesStatus ? '' : 'none';
                });
            }

            searchInput.addEventListener('input', filterUsers);
            roleFilter.addEventListener('change', filterUsers);
            statusFilter.addEventListener('change', filterUsers);

            // Funcionalitat de ordenació
            document.querySelectorAll('.sortable').forEach(header => {
                header.addEventListener('click', function() {
                    const column = this.dataset.sort;
                    const isAsc = this.classList.contains('asc');

                    // Netejar altres ordenacions
                    document.querySelectorAll('.sortable').forEach(h => {
                        h.classList.remove('asc', 'desc');
                    });

                    // Aplicar nova ordenació
                    this.classList.add(isAsc ? 'desc' : 'asc');

                    // Aquí implementaries la lògica d'ordenació real
                    console.log(`Ordenar per ${column} ${isAsc ? 'desc' : 'asc'}`);
                });
            });
        });
    </script>
@endsection
