<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    protected function testedBy()
    {
        $videos = Video::all();
        return response()->json($videos);
    }
    /**
     * Mostrar un vídeo específic.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Obtenir el vídeo pel seu ID
        $video = Video::findOrFail($id);

        // Retornar la vista amb el vídeo
        return view('videos.show', compact('video'));
    }
}
