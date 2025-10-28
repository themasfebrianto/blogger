<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return response()->json(Tag::all());
    }

    public function show(Tag $tag)
    {
        return response()->json($tag);
    }

    public function store(Request $request)
    {
        $tag = Tag::create($request->validate([
            'name' => 'required|string|max:255',
        ]));

        return response()->json($tag, 201);
    }

    public function update(Request $request, Tag $tag)
    {
        $tag->update($request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]));

        return response()->json($tag);
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->noContent();
    }
}
