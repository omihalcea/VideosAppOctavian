@extends('layouts.manager-layout')

@section('title', 'Notificacions en temps real')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h1 class="h4 mb-0">Notificacions en temps real</h1>
                    </div>
                    <div class="card-body">
                        <ul class="list-group" id="notifications">
                            @foreach ($notifications as $notification)
                                @php
                                    $videoId = $notification->data['video_id'] ?? null;
                                    $thumbnail = 'https://img.youtube.com/vi/' . \Illuminate\Support\Str::afterLast($notification->data['video_url'] ?? '', '/') . '/0.jpg';
                                @endphp

                                <li class="list-group-item d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $thumbnail }}" alt="Miniatura" class="me-3" width="100" height="56" style="object-fit: cover;">
                                        <div>
                                            <strong>{{ $notification->data['title'] }}</strong><br>
                                            <span>{{ $notification->data['message'] }}</span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ url('/videos/' . $videoId) }}" class="btn btn-sm btn-outline-primary">
                                            Veure vídeo
                                        </a>
                                        <div class="text-muted small mt-1">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        @if(count($notifications) === 0)
                            <div class="alert alert-info mt-3">
                                No hi ha notificacions disponibles.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const userId = document.querySelector('meta[name="user-id"]')?.getAttribute('content');
    </script>
@endsection
