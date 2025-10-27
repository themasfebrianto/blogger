<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Helpers\DatatableFilters;
use App\Helpers\FilterBuilders;
use App\Helpers\DatatableBuilders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // used by DataTables when fetching ajax data only
        if ($request->ajax()) {
            return $this->getDatatableData($request);
        }

        // Build filters
        $filters = $this->getDatatableFilters();

        // Build DataTable config
        $datatable = $this->datatableConfig();

        return view('admin.posts.index', compact('filters', 'datatable'));
    }

    /**
     * Build filter dropdowns or other controls
     */
    protected function getDatatableFilters()
    {
        $categories = Category::all();

        $statuses = collect([
            (object)['id' => 'draft', 'name' => 'Draft'],
            (object)['id' => 'published', 'name' => 'Published'],
        ]);

        return FilterBuilders::make()
            ->selectFromModel('category_id', 'All Categories', $categories)
            ->selectFromModel('status', 'All Status', $statuses)
            ->get();
    }

    /**
     * Build the DataTable column + AJAX setup
     */
    protected function datatableConfig()
    {
        return DatatableBuilders::make('posts-table')
            ->ajax(route('admin.posts.index'))
            ->addColumn('#', 'DT_RowIndex', false, false)
            ->addColumn('Title', 'title')
            ->addColumn('Author', 'author')
            ->addColumn('Category', 'category')
            ->addColumn('Tags', 'tags')
            ->addColumn('Excerpt', 'excerpt')
            ->addColumn('Slug', 'slug')
            ->addColumn('Status', 'status')
            ->addColumn('Created At', 'created_at')
            ->addColumn('Actions', 'action', false, false)
            ->order(6, 'desc')
            ->ajaxDataParam('category', '$("#filter-category").val()')
            ->ajaxDataParam('status', '$("#filter-status").val()')
            ->build();
    }

    /**
     * Handle the AJAX request for DataTables data
     */
    protected function getDatatableData(Request $request)
    {
        $query = Post::with(['user', 'category', 'tags'])->latest();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('author', fn($row) => $row->user?->name ?? '-')
            ->addColumn('category', fn($row) => $row->category?->name ?? '-')
            ->addColumn('tags', fn($row) => $row->tags?->pluck('name')->join(', ') ?? '-')
            ->addColumn('created_at', fn($row) => $row->created_at->format('d M Y H:i'))
            ->addColumn('action', fn($row) => datatable_actions(
                route('admin.posts.edit', $row->id),
                route('admin.posts.destroy', $row->id)
            ))
            ->filter(function ($query) use ($request) {
                DatatableFilters::applyFilters($query, $request, ['title']);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|min:3|max:255',
            'body'        => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
            'status'      => 'required|in:draft,published',
        ]);

        $slug = Str::slug($validated['title']);
        $slugCount = Post::where('slug', 'LIKE', "{$slug}%")->count();
        if ($slugCount > 0) {
            $slug .= '-' . ($slugCount + 1);
        }

        $post = Post::create([
            'user_id'     => Auth::id(),
            'title'       => $validated['title'],
            'slug'        => $slug,
            'excerpt'     => Str::limit(strip_tags($validated['body']), 200),
            'body'        => $validated['body'],
            'category_id' => $validated['category_id'] ?? null,
            'status'      => $validated['status'],
        ]);

        if (!empty($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully!');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title'       => 'required|min:3|max:255',
            'body'        => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
            'status'      => 'required|in:draft,published',
        ]);

        $post->update([
            'title'       => $validated['title'],
            'slug'        => Str::slug($validated['title']),
            'excerpt'     => Str::limit(strip_tags($validated['body']), 200),
            'body'        => $validated['body'],
            'category_id' => $validated['category_id'] ?? null,
            'status'      => $validated['status'],
        ]);

        $post->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully!');
    }
}
