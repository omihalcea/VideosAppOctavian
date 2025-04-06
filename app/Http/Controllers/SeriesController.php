<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $query = Series::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $series = $query->latest()->paginate(9);
        return view('series.index', compact('series'));
    }

    public function show(Series $series)
    {
        $series->load('videos');
        return view('series.show', compact('series'));
    }

}
