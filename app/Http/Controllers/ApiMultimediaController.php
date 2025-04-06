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
        \Log::info('Petició rebuda a store()', ['request' => $request->all()]);

        $request->validate([
            'file' => 'required|max:51200',
        ]);

        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file uploaded'], 422);
        }

        $path = $request->file('file')->store('uploads', 'public');

        $file = Multimedia::create([
            'user_id' => auth()->id(),
            'filename' => $request->file('file')->getClientOriginalName(),
            'type' => $request->file('file')->getClientMimeType(),
            'size' => $request->file('file')->getSize(),
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
