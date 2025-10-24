@extends('admin.layouts.app')

@section('page-actions')
    @include('admin.shared.createButton', ['route' => route('admin.posts.create')])
@endsection

@section('content')
    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Posts Table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Filters -->
            @include('admin.shared.datatableFilters', ['filters' => $filters, 'tableId' => 'posts-table'])
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0" id="posts-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Tags</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            // Initialize the DataTable
            const table = $('#posts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.posts.index') }}',
                    data: function(d) {
                        d.category = $('#filter-category').val();
                        d.status = $('#filter-status').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'author',
                        name: 'author'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'tags',
                        name: 'tags'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [6, 'desc']
                ], // use index 6 (created_at)
            });

            // Listen to dropdown filter changes
            $('#filter-category, #filter-status').on('change', function() {
                table.ajax.reload();
            });
        });
    </script>
@endpush
