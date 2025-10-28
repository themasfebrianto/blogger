<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\YaumiActivity;
use App\Models\YaumiLog;
use App\Models\YaumiStreak;

class DashboardController extends Controller
{
    public function index()
    {
        // Content counts
        $postCount     = Post::count();
        $categoryCount = Category::count();
        $tagCount      = Tag::count();
        $commentCount  = Comment::count();
        $recentPosts   = Post::latest()->with(['user', 'category'])->take(5)->get();

        // Yaumi counts
        $activityCount  = YaumiActivity::count();
        $logCount       = YaumiLog::count();
        $streakCount    = YaumiStreak::count();

        // Recent data
        $activities = YaumiActivity::all();
        $recentLogs       = YaumiLog::with('activity')->latest()->take(5)->get();
        $topStreaks       = YaumiStreak::with('user')
            ->orderByDesc('current_streak')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'postCount',
            'categoryCount',
            'tagCount',
            'commentCount',
            'recentPosts',
            'activityCount',
            'logCount',
            'streakCount',
            'activities',
            'recentLogs',
            'topStreaks'
        ));
    }
}
