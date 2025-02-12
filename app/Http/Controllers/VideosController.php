<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Tests\Unit\VideosTest;

class VideosController extends Controller // Assegura't que estén Controller
{
    protected function testedBy()
    {
        return VideosTest::class;
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

    public function manage()
    {
        // Obtenir tots els vídeos
        $videos = Video::all();

        // Retornar la vista de gestió de vídeos
        return view('videos.manage', compact('videos'));
    }
}
