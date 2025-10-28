@extends('admin.layouts.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.yaumi-activities.store') }}" method="POST">
                @include('admin.yaumi-activities._form', ['submit' => 'Create'])
            </form>
        </div>
    </div>
@endsection
