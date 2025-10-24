@extends('admin.layouts.app')

@section('page-actions')
    @include('admin.shared.createButton', ['route' => route('admin.posts.create')])
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">

            {{-- Filters --}}
            @include('admin.shared.datatableFilters', [
                'filters' => $filters,
                'tableId' => 'posts-table',
            ])

            {{-- Reusable DataTable --}}
            @include('admin.shared.datatable', [
                'id' => 'posts-table',
                'ajax' => route('admin.posts.index'),
                'columns' => [
                    ['#', 'DT_RowIndex', false, false],
                    ['Title', 'title'],
                    ['Author', 'author'],
                    ['Category', 'category'],
                    ['Tags', 'tags'],
                    ['Status', 'status'],
                    ['Created At', 'created_at'],
                    ['Actions', 'action', false, false],
                ],
                'order' => [[6, 'desc']], // index of 'created_at'
                'options' => [
                    'ajax' => [
                        'url' => route('admin.posts.index'),
                        'data' =>
                            'function(d) {  d.category = $("#filter-category").val();   d.status = $("#filter-status").val(); }',
                    ],
                ],
            ])
        </div>
    </div>
@endsection
