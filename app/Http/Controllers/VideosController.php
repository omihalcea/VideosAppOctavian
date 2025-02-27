<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Tests\Unit\VideosTest;

class VideosController extends Controller // Assegura't que estén Controller
{
    protected function testedBy()
    {
        return VideosTest::class;
    }

    /**
     * Mostrar la llista de tots els vídeos.
     *
     * @return View
     */
    public function index()
    {
        // Obtenir tots els vídeos de la base de dades
        $videos = Video::all();

        // Retornar la vista amb la llista de vídeos
        return view('manage.index', compact('videos'));
    }


    /**
     * Mostrar un vídeo específic.
     *
     * @param int $id
     * @return View
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
