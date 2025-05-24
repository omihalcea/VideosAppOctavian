@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'icon' => null
])

@php
    $baseClasses = 'btn fw-medium d-inline-flex align-items-center justify-content-center text-decoration-none border-0 transition-all';

    $variants = [
        'primary' => 'btn-primary-custom',
        'secondary' => 'btn-secondary-custom',
        'success' => 'btn-success-custom',
        'danger' => 'btn-danger-custom',
        'warning' => 'btn-warning-custom',
        'info' => 'btn-info-custom',
        'outline' => 'btn-outline-custom'
    ];

    $sizes = [
        'sm' => 'btn-sm-custom',
        'md' => 'btn-md-custom',
        'lg' => 'btn-lg-custom'
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i class="bi bi-{{ $icon }} me-2"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i class="bi bi-{{ $icon }} me-2"></i>
        @endif
        {{ $slot }}
    </button>
@endif
