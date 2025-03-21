@extends('layouts.user-manager')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-bold mb-6 text-gray-800">{{ $user->name }}</h1>

        @if($user->videos->isEmpty())
            <p class="text-gray-600 text-lg">No hi ha vídeos disponibles.</p>
        @else
            <div class="overflow-x-auto bg-white shadow-md rounded-lg p-6">
                <table class="w-full border-collapse">
                    <thead>
                    <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-6 px-8 text-left">ID</th>
                        <th class="py-6 px-8 text-left">Títol</th>
                        <th class="py-6 px-8 text-left">Data de creació</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-lg">
                    @foreach ($user->videos as $video)
                        <tr class="border-b border-gray-300 hover:bg-gray-100">
                            <td class="py-5 px-8">{{ $video->id }}</td>
                            <td class="py-5 px-8">{{ $video->title }}</td>
                            <td class="py-5 px-8">{{ $video->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <a href="{{ route('users.index') }}" class="btn btn-secondary" data-qa="cancel-button">Cancel·lar</a>
@endsection
