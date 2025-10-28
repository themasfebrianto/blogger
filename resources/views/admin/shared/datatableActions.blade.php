<div class="d-flex gap-2 align-items-center" style="gap: 0.25rem;">
    @if ($editUrl)
        <a href="{{ $editUrl }}"
            class="btn btn-sm btn-primary d-inline-flex align-items-center justify-content-center" title="Edit"
            style="width:32px; height:32px; border-radius:6px;">
            <i class="fas fa-edit"></i>
        </a>
    @endif

    @if ($deleteUrl)
        @php $formId = 'delete-form-' . uniqid(); @endphp
        <form id="{{ $formId }}" action="{{ $deleteUrl }}" method="POST" style="margin:0;">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-sm btn-danger delete-btn" data-form-id="{{ $formId }}">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    @endif
</div>
<script>
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.delete-btn');
        if (!btn) return;

        e.preventDefault();
        const formId = btn.dataset.formId;

        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    });
</script>
