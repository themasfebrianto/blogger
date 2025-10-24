@extends('admin.layouts.app')

@section('page-actions')
    @include('admin.shared.createButton', ['route' => route('admin.categories.create')])
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
                'ajax' => route('admin.categories.index'),
                'columns' => [
                    ['#', 'DT_RowIndex', false, false],
                    ['Name', 'name'],
                    ['Slug', 'slug'],
                    ['Description', 'description'],
                    ['Created At', 'created_at'],
                    ['Actions', 'action', false, false],
                ],
                'order' => [4, 'desc'],
            ])
        </div>
    </div>
@endsection
