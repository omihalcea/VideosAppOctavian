<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

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
            'published_at' => now(), // Assignar automàticament la data de publicació
            'previous' => $lastVideo ? $lastVideo->id : null, // Assignar el vídeo anterior
            'next' => null, // De moment, no té següent vídeo
        ]);

        // Actualitzar el camp 'next' del vídeo anterior (si n'hi havia)
        if ($lastVideo) {
            $lastVideo->update(['next' => $video->id]);
        }

        return redirect()->route('manage.index')->with('success', 'Vídeo afegit correctament.');
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
