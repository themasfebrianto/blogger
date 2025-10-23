<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;

class DashboardController extends Controller
{
    public function index()
    {
        $recentPosts = Post::latest()
            ->with(['user', 'category']) // pastikan relasi sudah ada di model
            ->take(5)
            ->get();

        $postCount     = Post::count();
        $categoryCount = Category::count();
        $tagCount      = Tag::count();
        $commentCount  = Comment::count();

        return view('admin.dashboard', compact(
            'recentPosts',
            'postCount',
            'categoryCount',
            'tagCount',
            'commentCount'
        ));
    }
}
