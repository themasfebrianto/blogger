@extends('admin.layouts.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST">
                @method('PUT')
                @include('admin.tags._form', ['submit' => 'Update'])
            </form>
        </div>
    </div>
@endsection
