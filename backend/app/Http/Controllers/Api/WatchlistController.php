<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Watchlist;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function index()
    {
        $items = Watchlist::with('anime')->get();

        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anime_id' => 'required|integer|exists:anime,id',
        ]);

        $item = Watchlist::create($validated);

        return response()->json($item, 201);
    }

    public function show(string $id)
    {
        $item = Watchlist::with('anime')->findOrFail($id);

        return response()->json($item);
    }

    public function destroy(string $id)
    {
        $item = Watchlist::findOrFail($id);
        $item->delete();

        return response()->json(null, 204);
    }
}
