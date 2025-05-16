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
        $files = Multimedia::with('user')->orderBy('created_at', 'desc')->get();
        return response()->json($files);
    }

    public function profile()
    {
        $user = Auth::user();
        $files = Multimedia::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return response()->json($files);
    }

    public function show($id)
    {
        $file = Multimedia::findOrFail($id);
        return response()->json($file);
    }

    public function store(Request $request)
    {
        $uploadedFile = $request->file('file');
        $mimeType = $uploadedFile->getClientMimeType();

        $fileType = 'document';
        if (str_starts_with($mimeType, 'image/')) {
            $fileType = 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            $fileType = 'video';
        }

        $fileName = $uploadedFile->getClientOriginalName();
        $path = $uploadedFile->storeAs('uploads', $fileName, 'public');

        try {
            $file = Multimedia::create([
                'user_id' => auth()->id(),
                'filename' => $fileName,
                'display_name' => $request->input('name', pathinfo($fileName, PATHINFO_FILENAME)),
                'description' => $request->input('description'),
                'type' => $fileType,
                'size' => $uploadedFile->getSize(),
                'path' => $path,
            ]);

            return response()->json($file, 201);

        } catch (\Exception $e) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'error' => 'Error al pujar el fitxer',
                'details' => config('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'display_name' => 'sometimes|string|max:255',
            'description' => 'nullable|string'
        ]);

        $file = Multimedia::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $file->update([
            'display_name' => $request->input('display_name', $file->display_name),
            'description' => $request->input('description', $file->description)
        ]);

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
