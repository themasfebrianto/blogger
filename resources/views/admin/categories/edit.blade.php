@extends('admin.layouts.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @method('PUT')
                @include('admin.categories._form', ['submit' => 'Update'])
            </form>
        </div>
    </div>
@endsection
