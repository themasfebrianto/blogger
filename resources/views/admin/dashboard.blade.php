@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Blog Overview</h1>
        <a href="{{ route('admin.posts.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> New Post
        </a>
    </div>

    <div class="row">

        <!-- Total Posts -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Posts
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $postCount ?? 0 }}</div>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Categories
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $categoryCount ?? 0 }}</div>
                </div>
            </div>
        </div>

        <!-- Tags -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Tags
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tagCount ?? 0 }}</div>
                </div>
            </div>
        </div>

        <!-- Comments -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Comments
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $commentCount ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Posts -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Recent Posts</h6>
            <a href="{{ route('admin.posts.index') }}" class="small">View All</a>
        </div>
        <div class="card-body">
            @if (!empty($recentPosts) && count($recentPosts))
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Published</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentPosts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->user->name ?? 'N/A' }}</td>
                                    <td>{{ $post->category->name ?? '-' }}</td>
                                    <td>{{ $post->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="mb-0 text-muted">No recent posts found.</p>
            @endif
        </div>
    </div>
@endsection
