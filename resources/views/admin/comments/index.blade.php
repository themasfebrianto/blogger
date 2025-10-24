@extends('admin.layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">

            {{-- Filters --}}
            @include('admin.shared.datatableFilters', [
                'filters' => $filters,
                'tableId' => 'comments-table',
            ])

            {{-- Reusable DataTable --}}
            @include('admin.shared.datatable', [
                'id' => 'comments-table',
                'ajax' => route('admin.comments.index'),
                'columns' => [
                    ['#', 'DT_RowIndex', false, false],
                    ['Post', 'post'],
                    ['User', 'user'],
                    ['Comment', 'body'],
                    ['Created At', 'created_at'],
                    ['Actions', 'action', false, false],
                ],
                'order' => [[4, 'desc']],
                'options' => [
                    'ajax' => [
                        'url' => route('admin.comments.index'),
                        'data' =>
                            'function(d) { d.post_id = $("#filter-post_id").val();  d.user_id = $("#filter-user_id").val(); }',
                    ],
                ],
            ])
        </div>
    </div>
@endsection
