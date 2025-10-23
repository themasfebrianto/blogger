@csrf

<div class="row">
    {{-- Left Sidebar: Small meta fields --}}
    <div class="col-md-4 col-lg-3 order-2 order-md-1">
        <div class="card mb-3">
            <div class="card-body p-3">
                {{-- Title --}}
                <div class="mb-3">
                    <label for="title" class="form-label small fw-semibold text-muted">Title</label>
                    <input type="text" class="form-control form-control-sm @error('title') is-invalid @enderror"
                        id="title" name="title" placeholder="Enter title..."
                        value="{{ old('title', $post->title ?? '') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Category --}}
                <div class="mb-3">
                    <label for="category_id" class="form-label small fw-semibold text-muted">Category</label>
                    <select name="category_id" id="category_id" class="form-select form-select-sm select2" required>
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tags --}}
                <div class="mb-3">
                    <label for="tags" class="form-label small fw-semibold text-muted">Tags</label>
                    <select name="tags[]" id="tags" class="form-select form-select-sm select2" multiple>
                        @php
                            $selectedTags = old('tags', isset($post) ? $post->tags->pluck('id')->toArray() : []);
                        @endphp
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}"
                                {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label for="status" class="form-label small fw-semibold text-muted">Status</label>
                    <select name="status" id="status" class="form-select form-select-sm select2">
                        <option value="draft" {{ old('status', $post->status ?? '') == 'draft' ? 'selected' : '' }}>
                            Draft</option>
                        <option value="published"
                            {{ old('status', $post->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="d-flex gap-4">
            <button type="submit" class="btn btn-primary w-100">{{ $submit ?? 'Save' }}</button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary w-100">Cancel</a>
        </div>
    </div>

    {{-- Main Editor --}}
    <div class="col-md-8 col-lg-9 order-1 order-md-2 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div id="editor" style="height: 500px;" class="border-0 rounded-2">
                    {!! old('body', $post->body ?? '') !!}
                </div>
                <textarea name="body" id="body" class="d-none">{{ old('body', $post->body ?? '') }}</textarea>
            </div>
        </div>
        @error('body')
            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#category_id').select2({
                placeholder: "Select a category",
                allowClear: true,
                width: '100%'
            });
            $('#tags').select2({
                placeholder: "Select tags",
                allowClear: true,
                width: '100%'
            });
            $('#status').select2({
                minimumResultsForSearch: Infinity,
                width: '100%'
            });
        });

        $(document).ready(function() {
            // Select2 init
            $('#category_id').select2({
                placeholder: "Select a category",
                allowClear: true,
                width: '100%'
            });
            $('#tags').select2({
                placeholder: "Select tags",
                allowClear: true,
                width: '100%'
            });
            $('#status').select2({
                minimumResultsForSearch: Infinity,
                width: '100%'
            });

            // === Quill init ===
            const quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: 'Write something awesome...',
                modules: {
                    toolbar: [
                        [{
                            'header': [1, 2, 3, false]
                        }],
                        ['bold', 'italic', 'underline', 'blockquote'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        ['link', 'image', 'code-block'],
                        ['clean']
                    ]
                }
            });

            // Sync ke textarea saat submit
            const form = $('form');
            form.on('submit', function() {
                $('#body').val(quill.root.innerHTML);
            });

            // Handle upload gambar
            function uploadImage(file) {
                const formData = new FormData();
                formData.append('file', file);

                // Sisipkan placeholder dulu
                const range = quill.getSelection(true);
                quill.insertEmbed(range.index, 'image', '/images/loading.gif');

                fetch('{{ route('admin.upload-image') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        // Replace placeholder dengan image asli
                        const img = quill.root.querySelector('img[src="/images/loading.gif"]');
                        if (img) img.src = data.url;
                    })
                    .catch(err => console.error('Upload failed', err));
            }

            // Override tombol image default
            quill.getModule('toolbar').addHandler('image', function() {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.click();
                input.onchange = function() {
                    const file = input.files[0];
                    if (file) uploadImage(file);
                };
            });
        });
    </script>
@endpush
