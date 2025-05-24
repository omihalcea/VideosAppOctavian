@props([
'icon' => 'inbox',
'title' => 'No hi ha elements',
'description' => 'No s\'han trobat elements per mostrar.',
'action' => null
])

<div class="empty-state-custom">
    <div class="empty-state-icon">
        <i class="bi bi-{{ $icon }}"></i>
    </div>
    <h3 class="empty-state-title">{{ $title }}</h3>
    <p class="empty-state-description">{{ $description }}</p>
    @if($action)
    <div class="empty-state-action">
        {{ $action }}
    </div>
    @endif
</div>
