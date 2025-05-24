@props([
    'title' => null,
    'subtitle' => null,
    'image' => null,
    'imageAlt' => '',
    'actions' => null,
    'href' => null
])

<div {{ $attributes->merge(['class' => 'card-custom']) }}>
    @if($image)
        <div class="card-image-container">
            @if($href)
                <a href="{{ $href }}" class="text-decoration-none">
                    <img src="{{ $image }}" class="card-img-custom" alt="{{ $imageAlt }}">
                </a>
            @else
                <img src="{{ $image }}" class="card-img-custom" alt="{{ $imageAlt }}">
            @endif
        </div>
    @endif

    <div class="card-body-custom">
        @if($title)
            <h5 class="card-title-custom">
                @if($href)
                    <a href="{{ $href }}" class="text-decoration-none text-dark">{{ $title }}</a>
                @else
                    {{ $title }}
                @endif
            </h5>
        @endif

        @if($subtitle)
            <p class="card-subtitle-custom">{{ $subtitle }}</p>
        @endif

        <div class="card-content-custom">
            {{ $slot }}
        </div>

        @if($actions)
            <div class="card-actions-custom">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>
