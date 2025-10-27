@extends('admin.layouts.app')

@section('page-actions')
    @include('admin.shared.createButton', ['route' => route('admin.posts.create')])
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">

            {{-- Filters --}}
            @include('admin.shared.datatableFilters', [
                'filters' => $filters,
                'tableId' => $datatable['id'],
            ])

            {{-- DataTable --}}
            @include('admin.shared.datatable', $datatable)

        </div>
    </div>
@endsection
