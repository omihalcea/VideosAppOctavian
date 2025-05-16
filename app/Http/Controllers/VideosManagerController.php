<?php

namespace App\Http\Controllers;

use App\Events\VideoCreated;
use App\Models\User;
use App\Models\Video;
use App\Notifications\VideoCreatedNotification;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class VideosManagerController extends Controller
{
    public function index()
    {
        $videos = Video::all();
        return view('manage.index', compact('videos')); // Canviat per la vista correcta
    }

    public function create()
    {
        return view('manage.create'); // Afegida funció per a la vista de creació
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url',
        ]);

        // Obtenir l'últim vídeo (si n'hi ha)
        $lastVideo = Video::orderBy('id', 'desc')->first();

        // Crear el nou vídeo
        $video = Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'user_id' => Auth::id(),
            'published_at' => now(),
            'previous' => $lastVideo ? $lastVideo->id : null,
            'next' => null,
        ]);

        // Disparar l’event
        event(new VideoCreated($video));

        // Actualitzar el camp 'next' del vídeo anterior (si n'hi havia)
        if ($lastVideo) {
            $lastVideo->update(['next' => $video->id]);
        }

        return redirect()->route('videos.index')->with('success', 'Vídeo afegit correctament.');
    }


    public function show(Video $video)
    {
        return view('videos.show', compact('video'));
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);
        $videos = Video::orderBy('id', 'asc')->get();
        return view('manage.edit', compact('video', 'videos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url',
        ]);

        $video = Video::findOrFail($id);

        // Actualitzar dades del vídeo
        $video->update([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
        ]);

        return redirect()->route('manage.index')->with('success', 'Vídeo actualitzat correctament.');
    }

    public function delete(Video $video)
    {
        return view('manage.delete', compact('video'));
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()->route('manage.index')->with('success', 'Vídeo eliminat correctament.');
    }
}
