@csrf

<div class="card shadow-sm border-0">
    <div class="card-body">

        {{-- Category Name --}}
        <div class="mb-3">
            <label for="name" class="form-label small fw-semibold text-muted">Name</label>
            <input type="text" id="name" name="name"
                class="form-control form-control-sm @error('name') is-invalid @enderror"
                placeholder="Enter category name..." value="{{ old('name', $category->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Slug (optional) --}}
        <div class="mb-3">
            <label for="slug" class="form-label small fw-semibold text-muted">Slug <span
                    class="text-muted">(optional)</span></label>
            <input type="text" id="slug" name="slug"
                class="form-control form-control-sm @error('slug') is-invalid @enderror"
                placeholder="Leave empty to auto-generate" value="{{ old('slug', $category->slug ?? '') }}">
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        {{-- Description --}}
        <div class="mb-4">
            <label for="description" class="form-label small fw-semibold text-muted">Description</label>
            <textarea id="description" name="description" rows="3"
                class="form-control form-control-sm @error('description') is-invalid @enderror"
                placeholder="Optional short description...">{{ old('description', $category->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Buttons --}}
        <div class="d-flex justify-content-end gap-2 pt-2 border-top">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-light border">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                {{ $submit ?? 'Save' }}
            </button>
        </div>

    </div>
</div>
