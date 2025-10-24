<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\DatatableFilters;
use App\Helpers\FilterBuilder;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDatatableData($request);
        }

        $posts = Post::select('id', 'title')->get();
        $users = User::select('id', 'name')->get();

        $filters = FilterBuilder::make()
            ->selectFromModel('post_id', 'All Posts', $posts)
            ->selectFromModel('user_id', 'All Users', $users)
            ->get();

        return view('admin.comments.index', compact('filters'));
    }


    protected function getDatatableData(Request $request)
    {
        $query = Comment::with(['post:id,title', 'user:id,name']);
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('post', fn($row) => $row->post?->title ?? '-')
            ->addColumn('user', fn($row) => $row->user?->name ?? '-')
            ->addColumn('body', fn($row) => str($row->body)->limit(60))
            ->addColumn('created_at', fn($row) => optional($row->created_at)?->format('d M Y H:i') ?? '-')
            ->addColumn(
                'action',
                fn($row) =>
                datatable_actions(
                    null,
                    route('admin.comments.destroy', $row->id)
                )
            )
            ->filter(function ($query) use ($request) {
                if ($request->filled('post_id')) $query->where('post_id', $request->post_id);
                if ($request->filled('user_id')) $query->where('user_id', $request->user_id);
            })
            ->rawColumns(['action'])
            ->make(true);
    }



    /**
     * Show the form for creating a new resource.
     * Tidak dibutuhkan di admin panel
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     * Tidak dibutuhkan di admin panel
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return view('admin.comments.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     * Tidak dibutuhkan di admin panel
     */
    public function edit(Comment $comment)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     * Digunakan untuk approve/unapprove
     */
    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $comment->update($data);

        return redirect()->route('admin.comments.index')->with('success', 'Comment status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments.index')->with('success', 'Comment deleted successfully.');
    }
}
