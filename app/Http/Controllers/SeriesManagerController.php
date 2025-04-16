<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeriesManagerController extends Controller
{
    /**
     * Llistar totes les sèries
     */
    public function index()
    {
        $series = Series::all();
        return view('series.manage.index', compact('series'));
    }

    public function create()
    {
        $videos = Video::whereNull('series_id')->get();
        return view('series.manage.create', compact('videos'));
    }


    /**
     * Guardar una nova sèrie
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $user = auth()->user();

        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('series/', $imageName, 'public');
        } else {
            $imageName = null;
        }

        $series = Series::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
            'user_name' => $user->name,
            'user_photo_url' => $user->profile_photo_url ?? null,
            'published_at' => $request->published_at,
        ]);

        if ($request->has('videos')) {
            Video::whereIn('id', $request->videos)->update(['series_id' => $series->id]);
        }

        // Redirigir amb un missatge de confirmació
        return redirect()->route('series.manage.index')->with('success', 'Sèrie creada correctament!');
    }


    /**
     * Formulari per editar una sèrie
     */
    public function edit(Series $series)
    {
        return view('series.manage.edit', compact('series'));
    }

    /**
     * Actualitzar una sèrie
     */
    public function update(Request $request, Series $series)
    {
        // Validació de les dades
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $series->title = $request->input('title');
        $series->description = $request->input('description');

        if ($request->hasFile('image')) {
            if ($series->image && Storage::disk('public')->exists('series/' . $series->image)) {
                Storage::disk('public')->delete('series/' . $series->image);
            }

            $imageName = $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('series/', $imageName, 'public');

            $series->image = $imageName;
        }

        if ($request->has('videos')) {
            Video::whereIn('id', $request->videos)->update(['series_id' => $series->id]);
        }

        $series->save();

        return redirect()->route('series.manage.index')->with('success', 'Sèrie actualitzada correctament!');
    }


    /**
     * Mostrar la vista per eliminar una sèrie
     */
    public function delete(Series $series)
    {
        return view('series.manage.delete', compact('series'));
    }

    /**
     * Eliminar una sèrie
     */
    public function destroy(Request $request, Series $series)
    {
        if ($series->image) {
            Storage::disk('public')->delete($series->image);
        }

        if ($request->has('delete_videos') && $request->delete_videos == 'yes') {
            // Eliminar els vídeos associats a la sèrie
            $series->videos()->delete();
        } else {
            // Desassignar els vídeos de la sèrie
            $series->videos()->update(['series_id' => null]);
        }
        $series->delete();
        return redirect()->route('series.manage.index')->with('success', 'Sèrie eliminada correctament!');
    }

    /**
     * Mostrar qui ha testejat una sèrie
     */
    public function testedBy()
    {
        return 'Tested by SeriesManagerController';
    }
}
