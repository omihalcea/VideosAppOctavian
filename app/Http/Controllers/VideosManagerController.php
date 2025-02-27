<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideosManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function testedBy()
    {
        return response()->json(['tested_by' => 'VideosManageController']);
    }

    public function index()
    {
        $videos = Video::all();
        return view('videos.index', compact('videos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url',
        ]);

        $video = Video::create($request->all());

        return redirect()->route('videos.index')->with('success', 'Vídeo creat correctament.');
    }

    public function show(Video $video)
    {
        return view('videos.show', compact('video'));
    }

    public function edit(Video $video)
    {
        return view('videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url',
        ]);

        $video->update($request->all());

        return redirect()->route('videos.index')->with('success', 'Vídeo actualitzat correctament.');
    }

    public function delete(Video $video)
    {
        return view('videos.delete', compact('video'));
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()->route('videos.index')->with('success', 'Vídeo eliminat correctament.');
    }
}
