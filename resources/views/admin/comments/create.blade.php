@extends('admin.layouts.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.tags.store') }}" method="POST">
                @include('admin.tags._form', ['submit' => 'Create'])
            </form>
        </div>
    </div>
@endsection
