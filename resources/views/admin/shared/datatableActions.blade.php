<div class="d-flex gap-2 align-items-center "style="gap: 0.25rem;">
    @if ($editUrl)
        <a href="{{ $editUrl }}"
            class="btn btn-sm btn-primary d-inline-flex align-items-center justify-content-center" title="Edit"
            style="width:32px; height:32px; border-radius:6px;">
            <i class="fas fa-edit"></i>
        </a>
    @endif

    @if ($deleteUrl)
        <form action="{{ $deleteUrl }}" method="POST" style="margin:0;"
            onsubmit="{{ $confirm ? "return confirm('Are you sure?');" : '' }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger d-inline-flex align-items-center justify-content-center"
                title="Delete" style="width:32px; height:32px; border-radius:6px;">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    @endif
</div>
