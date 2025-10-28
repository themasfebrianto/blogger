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
                'tableId' => 'yaumi-activities-table',
            ])

            {{-- DataTable --}}
            @include('admin.shared.datatable', $datatable)
        </div>
    </div>
@endsection
