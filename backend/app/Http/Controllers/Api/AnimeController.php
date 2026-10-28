<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function index(Request $request)
    {
        $query = Anime::query();

        if ($search = $request->query('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($genre = $request->query('genre')) {
            $query->where('genres', 'like', "%\"{$genre}%\"");
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $anime = $query->orderByDesc('created_at')->paginate(20);

        return response()->json($anime);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'nullable|string',
            'genres' => 'nullable|array',
            'release_year' => 'nullable|integer|min:1900|max:2100',
            'status' => 'required|in:ongoing,completed,upcoming',
            'rating' => 'nullable|numeric|min:0|max:10',
            'poster_url' => 'nullable|url',
            'banner_url' => 'nullable|url',
        ]);

        $anime = Anime::create($validated);

        return response()->json($anime, 201);
    }

    public function show(string $id)
    {
        $anime = Anime::findOrFail($id);

        return response()->json($anime);
    }

    public function update(Request $request, string $id)
    {
        $anime = Anime::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'synopsis' => 'nullable|string',
            'genres' => 'nullable|array',
            'release_year' => 'nullable|integer|min:1900|max:2100',
            'status' => 'sometimes|required|in:ongoing,completed,upcoming',
            'rating' => 'nullable|numeric|min:0|max:10',
            'poster_url' => 'nullable|url',
            'banner_url' => 'nullable|url',
        ]);

        $anime->update($validated);

        return response()->json($anime);
    }

    public function destroy(string $id)
    {
        $anime = Anime::findOrFail($id);
        $anime->delete();

        return response()->json(null, 204);
    }
}
