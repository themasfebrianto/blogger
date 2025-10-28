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

            {{-- DataTable --}}
            @include('admin.shared.datatable', $datatable)
        </div>
    </div>
@endsection
