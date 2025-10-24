@props(['route'])

@if ($route)
    <a href="{{ $route }}" class="btn btn-primary btn-sm d-flex align-items-center">
        Insert New <i class="ml-1 fas fa-plus me-1"></i>
    </a>
@endif
