@csrf

{{-- Title --}}
<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
        value="{{ old('title', $post->title ?? '') }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Category --}}
<div class="mb-3">
    <label for="category_id" class="form-label">Category</label>
    <select name="category_id" id="category_id" class="form-select select2" required>
        <option value="">-- Select Category --</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Tags --}}
<div class="mb-3">
    <label for="tags" class="form-label">Tags</label>
    <select name="tags[]" id="tags" class="form-select select2" multiple>
        @php
            $selectedTags = old('tags', isset($post) ? $post->tags->pluck('id')->toArray() : []);
        @endphp
        @foreach ($tags as $tag)
            <option value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}>
                {{ $tag->name }}
            </option>
        @endforeach
    </select>
    @error('tags')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Body --}}
<div class="mb-3">
    <label for="body" class="form-label">Body</label>
    <textarea name="body" id="body" rows="5" class="form-control @error('body') is-invalid @enderror"
        required>{{ old('body', $post->body ?? '') }}</textarea>
    @error('body')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Status --}}
<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select name="status" id="status" class="form-select select2" @error('status') is-invalid @enderror">
        <option value="draft" {{ old('status', $post->status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
        <option value="published" {{ old('status', $post->status ?? '') == 'published' ? 'selected' : '' }}>Published
        </option>
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Buttons --}}
<button type="submit" class="btn btn-primary">{{ $submit ?? 'Save' }}</button>
<a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Cancel</a>

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
    </script>
@endpush
