@extends('admin.layouts.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.yaumi-logs.store') }}" method="POST">
                @include('admin.yaumi-logs._form', ['submit' => 'Create'])
            </form>
        </div>
    </div>
@endsection
