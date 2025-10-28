@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Welcome Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-muted mb-0 small">Welcome back! Here's your overview</p>
        </div>
    </div>

    <!-- ===== Yaumi Activity Tracking ===== -->
    <div class="mb-4">
        <div class="d-flex align-items-center mb-3">
            <div class="bg-danger rounded-circle p-2 mr-2"
                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-heartbeat text-white" style="font-size: 14px;"></i>
            </div>
            <h6 class="mb-0 font-weight-bold text-gray-800">Yaumi Activity Tracking</h6>
        </div>

        <!-- Stats Row -->
        <div class="row g-3 mb-3">
            @foreach ([
            'Total Activities' => ['count' => $activityCount ?? 0, 'color' => 'primary', 'icon' => 'fa-star', 'bg' => 'primary'],
            'Total Logs' => ['count' => $logCount ?? 0, 'color' => 'success', 'icon' => 'fa-book', 'bg' => 'success'],
            'Active Streaks' => ['count' => $streakCount ?? 0, 'color' => 'warning', 'icon' => 'fa-fire', 'bg' => 'warning'],
        ] as $title => $data)
                <div class="col-lg-4 col-md-4">
                    <div class="card border-0 shadow-sm rounded-lg h-100"
                        style="border-left: 4px solid var(--{{ $data['color'] }}) !important;">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-{{ $data['bg'] }}-light rounded-circle mr-3 d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px; min-width: 48px;">
                                <i class="fas {{ $data['icon'] }} text-{{ $data['color'] }} fa-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="text-uppercase text-{{ $data['color'] }} font-weight-bold"
                                    style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                    {{ $title }}
                                </div>
                                <div class="h4 mb-0 font-weight-bold text-gray-900">{{ number_format($data['count']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Available Activities List -->
        <div class="card border-0 shadow-sm rounded-lg mb-3">
            <div class="card-body p-0">
                <div class="px-3 py-3 border-bottom bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-list-check text-primary mr-2"></i>
                            <h6 class="mb-0 font-weight-bold">Available Activities</h6>
                        </div>
                        <a href="{{ route('admin.yaumi-activities.index') }}" class="btn btn-sm btn-link text-primary p-0">
                            Manage <i class="fas fa-cog fa-sm ml-1"></i>
                        </a>
                    </div>
                </div>
                <div class="p-3">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                        @forelse ($activities as $activity)
                            <div class="col d-flex mb-4"> <!-- mb-4 untuk gap vertikal -->
                                <div class="card border shadow-sm rounded h-100 hover-shadow w-100">
                                    <div class="card-body p-3 text-center">
                                        <div class="bg-primary-light rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas {{ $activity->icon ?? 'fa-star' }} text-primary fa-lg"></i>
                                        </div>
                                        <h6 class="mb-1 font-weight-bold text-gray-900">{{ $activity->name }}</h6>
                                        <small class="badge badge-light">{{ $activity->logs_count ?? 0 }} logs</small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-4">
                                    <i class="fas fa-list-check text-gray-300 mb-2" style="font-size: 2rem;"></i>
                                    <p class="text-muted mb-2">No activities configured</p>
                                    <a href="{{ route('admin.yaumi-activities.index') }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-plus fa-sm"></i> Add Activities
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>


            </div>
        </div>

        <!-- Recent Logs & Top Streaks -->
        <div class="row g-3">
            <!-- Recent Logs -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-lg h-100">
                    <div class="card-body p-0">
                        <div class="px-3 py-3 border-bottom bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-book text-success mr-2"></i>
                                    <h6 class="mb-0 font-weight-bold">Recent Logs</h6>
                                </div>
                                <a href="{{ route('admin.yaumi-logs.index') }}"
                                    class="btn btn-sm btn-link text-success p-0">
                                    View All <i class="fas fa-arrow-right fa-sm ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="px-0 py-0" style="max-height: 280px; overflow-y: auto;">
                            @forelse ($recentLogs as $log)
                                <div
                                    class="px-3 py-2 border-bottom hover-bg-light d-flex justify-content-between align-items-center">
                                    <span
                                        class="font-weight-600 text-gray-800">{{ $log->activity->name ?? 'Unknown Activity' }}</span>
                                    <small class="text-muted">
                                        {{ $log->created_at->format('d M, H:i') }}
                                    </small>
                                </div>
                            @empty
                                <div class="p-4 text-center">
                                    <i class="fas fa-book text-gray-300 mb-2" style="font-size: 2rem;"></i>
                                    <p class="text-muted mb-0 small">No logs yet</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Streaks -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-lg h-100">
                    <div class="card-body p-0">
                        <div class="px-3 py-3 border-bottom bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-fire text-warning mr-2"></i>
                                    <h6 class="mb-0 font-weight-bold">Top Activity Streaks</h6>
                                </div>
                                <a href="{{ route('admin.yaumi-streaks.index') }}"
                                    class="btn btn-sm btn-link text-warning p-0">
                                    View All <i class="fas fa-arrow-right fa-sm ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="px-0 py-0" style="max-height: 280px; overflow-y: auto;">
                            @forelse ($topStreaks as $streak)
                                <div
                                    class="px-3 py-3 border-bottom hover-bg-light d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning-light rounded-circle mr-3 d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-warning"></i>
                                        </div>
                                        <span
                                            class="font-weight-600 text-gray-800">{{ $streak->user->name ?? 'Anonymous' }}</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="badge badge-warning px-3 py-2 font-weight-bold">
                                            <i class="fas fa-fire"></i> {{ $streak->current_streak }} days
                                        </div>
                                        <div>
                                            <small
                                                class="text-muted d-block mt-1">{{ $streak->updated_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center">
                                    <i class="fas fa-trophy text-gray-300 mb-2" style="font-size: 2.5rem;"></i>
                                    <p class="text-muted mb-0">No active streaks yet</p>
                                    <small class="text-muted">Start tracking activities to build streaks!</small>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Divider -->
    <div class="border-top my-4"></div>

    <!-- ===== Blog Statistics ===== -->
    <div class="mb-4">
        <div class="d-flex align-items-center mb-3">
            <div class="bg-primary rounded-circle p-2 mr-2"
                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-blog text-white" style="font-size: 14px;"></i>
            </div>
            <h6 class="mb-0 font-weight-bold text-gray-800">Blog Statistics</h6>
        </div>

        <!-- Stats Row -->
        <div class="row g-3 mb-3">
            @foreach ([
            'Total Posts' => ['count' => $postCount ?? 0, 'color' => 'primary', 'icon' => 'fa-newspaper'],
            'Categories' => ['count' => $categoryCount ?? 0, 'color' => 'success', 'icon' => 'fa-folder-open'],
            'Tags' => ['count' => $tagCount ?? 0, 'color' => 'info', 'icon' => 'fa-tags'],
            'Comments' => ['count' => $commentCount ?? 0, 'color' => 'warning', 'icon' => 'fa-comments'],
        ] as $title => $data)
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-lg h-100"
                        style="border-left: 4px solid var(--{{ $data['color'] }}) !important;">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-{{ $data['color'] }}-light rounded-circle mr-3 d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px; min-width: 48px;">
                                <i class="fas {{ $data['icon'] }} text-{{ $data['color'] }} fa-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="text-uppercase text-{{ $data['color'] }} font-weight-bold"
                                    style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                    {{ $title }}
                                </div>
                                <div class="h4 mb-0 font-weight-bold text-gray-900">{{ number_format($data['count']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-primary shadow-sm mb-2">
            <i class="fas fa-plus fa-sm"></i> New Post
        </a>
        <!-- Recent Posts -->
        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-body p-0">
                <div class="px-3 py-3 border-bottom bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-newspaper text-primary mr-2"></i>
                            <h6 class="mb-0 font-weight-bold">Recent Blog Posts</h6>
                        </div>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-link text-primary p-0">
                            View All <i class="fas fa-arrow-right fa-sm ml-1"></i>
                        </a>
                    </div>
                </div>
                <div class="p-3">
                    <div class="row">
                        @forelse ($recentPosts as $post)
                            <div class="col-lg-4 col-md-6 mb-4"> <!-- mb-4 untuk gap vertikal -->
                                <div class="card border shadow-sm rounded h-100 hover-shadow">
                                    <div class="card-body p-3">
                                        <h6 class="font-weight-bold text-gray-900 mb-2" style="line-height: 1.4;">
                                            {{ Str::limit($post->title, 50) }}
                                        </h6>
                                        <div class="mb-2">
                                            <span class="badge badge-primary badge-pill px-2 py-1 small">
                                                <i class="fas fa-folder fa-sm"></i>
                                                {{ $post->category->name ?? 'Uncategorized' }}
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center text-muted mb-2" style="font-size: 0.8rem;">
                                            <i class="fas fa-user fa-sm mr-1"></i>
                                            <span>{{ $post->user->name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center text-muted" style="font-size: 0.75rem;">
                                            <i class="fas fa-clock fa-sm mr-1"></i>
                                            <span>{{ $post->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white border-top p-2">
                                        <a href="{{ route('admin.posts.show', $post) }}"
                                            class="btn btn-sm btn-outline-primary btn-block">
                                            <i class="fas fa-eye fa-sm"></i> View Post
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-4">
                                    <i class="fas fa-newspaper text-gray-300 mb-3" style="font-size: 3rem;"></i>
                                    <p class="text-muted mb-2">No recent posts found</p>
                                    <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus fa-sm"></i> Create your first post
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>

    <style>
        .hover-bg-light:hover {
            background-color: #f8f9fc;
            cursor: pointer;
        }

        .hover-shadow {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .bg-primary-light {
            background-color: rgba(78, 115, 223, 0.1);
        }

        .bg-success-light {
            background-color: rgba(28, 200, 138, 0.1);
        }

        .bg-warning-light {
            background-color: rgba(246, 194, 62, 0.1);
        }

        .bg-info-light {
            background-color: rgba(54, 185, 204, 0.1);
        }

        .bg-danger-light {
            background-color: rgba(231, 74, 59, 0.1);
        }

        .font-weight-600 {
            font-weight: 600;
        }
    </style>
@endsection
