<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\DatatableFilters;
use App\Helpers\FilterBuilder;
use Illuminate\Http\Request;

class CategoryController extends Controller
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

        return view('admin.categories.index', compact('filters'));
    }

    protected function getDatatableData(Request $request)
    {
        $query = Category::query();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('name', fn($row) => $row->name)
            ->addColumn('slug', fn($row) => $row->slug)
            ->addColumn('description', fn($row) => $row->description)
            ->addColumn('created_at', fn($row) => $row->created_at->format('d M Y H:i'))
            ->addColumn('action', function ($row) {
                return datatable_actions(
                    route('admin.categories.edit', $row->id),
                    route('admin.categories.destroy', $row->id)
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
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // Opsional: biasanya untuk admin, show tidak terlalu dipakai
        return redirect()->route('admin.categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
