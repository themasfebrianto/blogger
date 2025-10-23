@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4">Create Post</h1>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('admin.posts.store') }}" method="POST">
                    @include('admin.posts._form', ['submit' => 'Create'])
                </form>
            </div>
        </div>
    </div>
@endsection
