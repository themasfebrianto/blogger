<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(Post::with(['category','user','tags'])->get());
    }

    public function show(Post $post)
    {
        return response()->json($post->load(['category','user','tags']));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'body' => 'required|string',
            'status' => 'in:draft,published',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post = Post::create($data);
        if (!empty($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return response()->json($post->load('tags'), 201);
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'category_id' => 'sometimes|required|exists:categories,id',
            'title' => 'sometimes|required|string|max:255',
            'excerpt' => 'nullable|string',
            'body' => 'sometimes|required|string',
            'status' => 'in:draft,published',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post->update($data);
        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return response()->json($post->load('tags'));
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->noContent();
    }
}
