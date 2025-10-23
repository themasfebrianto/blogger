@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4">Edit Post</h1>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
                    @method('PUT')
                    @include('admin.posts._form', ['submit' => 'Update'])
                </form>
            </div>
        </div>
    </div>
@endsection
