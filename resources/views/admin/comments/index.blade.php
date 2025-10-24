@extends('admin.layouts.app')

@section('content')
    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Comments Table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Post Title</th>
                            <th>Comment</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $comment->user->name }}</td>
                                <td>{{ $comment->post->name ?? 'N/A' }}</td>
                                <td>{{ $comment->body ?? 'N/A' }}</td>
                                <td>{{ $comment->created_at->format('d M Y') }}</td>
                                <td>
                                    {{-- <a href="{{ route('admin.comments.edit', $comment->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a> --}}
                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No comments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
@endsection
