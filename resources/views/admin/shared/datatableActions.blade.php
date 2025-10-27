<div class="d-flex gap-1 align-items-center">
    @if ($editUrl)
        <a href="{{ $editUrl }}" class="btn btn-sm btn-primary" title="Edit">
            <i class="fas fa-edit"></i>
        </a>
    @endif

    @if ($deleteUrl)
        <form action="{{ $deleteUrl }}" method="POST" style="display:inline-block; margin:0;"
            onsubmit="{{ $confirm ? "return confirm('Are you sure?');" : '' }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    @endif
</div>
