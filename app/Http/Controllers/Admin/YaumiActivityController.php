<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\YaumiActivity;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\DatatableFilters;
use App\Helpers\DatatableBuilders;
use App\Helpers\FilterBuilders;

class YaumiActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDatatableData($request);
        }

        $filters = $this->getDatatableFilters();

        $datatable = $this->datatableConfig();

        return view('admin.yaumi-activities.index', compact('filters', 'datatable'));
    }

    protected function getDatatableFilters()
    {
        $statuses = collect([
            (object)['id' => '1', 'name' => 'Active'],
            (object)['id' => '0', 'name' => 'Inactive'],
        ]);

        return FilterBuilders::make()
            ->selectFromModel('is_active', 'All Status', $statuses)
            ->get();
    }

    protected function datatableConfig()
    {
        return DatatableBuilders::make('yaumi-activities-table')
            ->ajax(route('admin.yaumi-activities.index'))
            ->addColumn('#', 'DT_RowIndex', false, false)
            ->addColumn('Name', 'name')
            ->addColumn('Description', 'description')
            ->addColumn('Icon', 'icon')
            ->addColumn('Order', 'order')
            ->addColumn('Is Active', 'is_active')
            ->addColumn('Created At', 'created_at')
            ->addColumn('Actions', 'action', false, false)
            ->order(4, 'asc')
            ->build();
    }

    protected function getDatatableData(Request $request)
    {
        $query = YaumiActivity::query();
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('is_active', fn($row) => $row->is_active ? '✅ Active' : '❌ Inactive')
            ->editColumn('created_at', fn($row) => $row->created_at->format('d M Y H:i'))
            ->addColumn('action', function ($row) {
                return datatable_actions(
                    route('admin.yaumi-activities.edit', $row->id),
                    route('admin.yaumi-activities.destroy', $row->id)
                );
            })
            ->filter(function ($query) use ($request) {
                DatatableFilters::applyFilters($query, $request, ['name', 'is_active']);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.yaumi-activities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:yaumi-activities,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        YaumiActivity::create($data);

        return redirect()
            ->route('admin.yaumi-activities.index')
            ->with('success', 'Yaumi Activity created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(YaumiActivity $yaumiActivity)
    {
        return view('admin.yaumi-activities.edit', compact('yaumiActivity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, YaumiActivity $yaumiActivity)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:yaumi-activities,name,' . $yaumiActivity->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $yaumiActivity->update($data);

        return redirect()
            ->route('admin.yaumi-activities.index')
            ->with('success', 'Yaumi Activity updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(YaumiActivity $yaumiActivity)
    {
        $yaumiActivity->delete();

        return redirect()
            ->route('admin.yaumi-activities.index')
            ->with('success', 'Yaumi Activity deleted successfully.');
    }
}
