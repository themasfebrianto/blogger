@extends('admin.layouts.app')

@section('page-actions')
    <a href="{{ route('admin.tags.create') }}" class="btn btn-primary ">Create New Tags</a>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            {{-- Filters --}}

            {{-- Reusable DataTable --}}
            @include('admin.shared.datatable', [
                'id' => 'category-table',
                'ajax' => route('admin.tags.index'),
                'columns' => [
                    ['#', 'DT_RowIndex', false, false],
                    ['Name', 'name'],
                    ['Slug', 'slug'],
                    ['Created At', 'created_at'],
                    ['Actions', 'action', false, false],
                ],
                'order' => [4, 'desc'],
            ])
        </div>
    </div>
@endsection
