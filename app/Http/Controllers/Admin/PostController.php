<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()
            ->with(['user', 'category', 'tags'])
            ->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|min:3|max:255',
            'body'        => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
            'status'      => 'required|in:draft,published',
        ]);

        $slug = Str::slug($validated['title']);
        $slugCount = Post::where('slug', 'LIKE', "{$slug}%")->count();
        if ($slugCount > 0) {
            $slug .= '-' . ($slugCount + 1);
        }

        $post = Post::create([
            'user_id'     => Auth::id(),
            'title'       => $validated['title'],
            'slug'        => $slug,
            'excerpt'     => Str::limit(strip_tags($validated['body']), 200),
            'body'        => $validated['body'],
            'category_id' => $validated['category_id'] ?? null,
            'status'      => $validated['status'],
        ]);

        if (!empty($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully!');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title'       => 'required|min:3|max:255',
            'body'        => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
            'status'      => 'required|in:draft,published',
        ]);

        $post->update([
            'title'       => $validated['title'],
            'slug'        => Str::slug($validated['title']),
            'excerpt'     => Str::limit(strip_tags($validated['body']), 200),
            'body'        => $validated['body'],
            'category_id' => $validated['category_id'] ?? null,
            'status'      => $validated['status'],
        ]);

        $post->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully!');
    }
}
