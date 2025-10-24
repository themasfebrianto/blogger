<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\DatatableFilters;
use App\Helpers\FilterBuilder;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDatatableData($request);
        }

        $filters = [
            'name' => null,
        ];

        return view('admin.tags.index', compact('filters'));
    }

    protected function getDatatableData(Request $request)
    {
        $query = Tag::query();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('name', fn($row) => $row->name)
            ->addColumn('slug', fn($row) => $row->slug)
            ->addColumn('created_at', fn($row) => $row->created_at->format('d M Y H:i'))
            ->addColumn('action', function ($row) {
                return datatable_actions(
                    route('admin.tags.edit', $row->id),
                    route('admin.tags.destroy', $row->id)
                );
            })
            ->filter(function ($query) use ($request) {
                DatatableFilters::applyFilters($query, $request, [
                    'name',
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        Tag::create($data);

        return redirect()->route('admin.tags.index')->with('success', 'Tag created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        // Opsional, biasanya show tidak digunakan di admin
        return redirect()->route('admin.tags.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
        ]);

        $tag->update($data);

        return redirect()->route('admin.tags.index')->with('success', 'Tag updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Tag deleted successfully.');
    }
}
