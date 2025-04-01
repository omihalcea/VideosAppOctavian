<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Multimedia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ApiMultimediaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $files = Multimedia::where('user_id', $user->id)->get();
        return response()->json($files);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,mp4|max:51200',
        ]);

        $user = Auth::user();
        $path = $request->file('file')->store('uploads', 'public');

        $file = Multimedia::create([
            'user_id' => $user->id,
            'path' => $path,
        ]);

        return response()->json($file, 201);
    }

    public function show($id)
    {
        $file = Multimedia::findOrFail($id);
        return response()->json($file);
    }

    public function destroy($id)
    {
        $file = Multimedia::findOrFail($id);

        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }

        $file->delete();

        return response()->json(['message' => 'Arxiu esborrat correctament'], 200);
    }
}
