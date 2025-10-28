<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\DatatableBuilders;
use App\Helpers\DatatableFilters;
use App\Helpers\FilterBuilders;
use App\Models\YaumiLog;
use App\Models\User;
use Illuminate\Http\Request;

class YaumiLogController extends Controller
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

        return view('admin.yaumi-logs.index', compact('filters', 'datatable'));
    }

    protected function getDatatableFilters()
    {
        $users = User::orderBy('name')->get();

        return FilterBuilders::make()
            ->selectFromModel('user_id', 'All Users', $users)
            ->date('date', 'Log Date')
            ->get();
    }

    protected function datatableConfig()
    {
        return DatatableBuilders::make('yaumi-logs-table')
            ->ajax(route('admin.yaumi-logs.index'))
            ->addColumn('#', 'DT_RowIndex', false, false)
            ->addColumn('User', 'user_name')
            ->addColumn('Activity', 'activity_name')
            ->addColumn('Status', 'status')
            ->addColumn('Note', 'note')
            ->addColumn('Logged At', 'created_at')
            ->order(5, 'desc')
            ->build();
    }

    protected function getDatatableData(Request $request)
    {
        $query = YaumiLog::query()
            ->with(['user', 'activity'])
            ->when($request->user_id, fn($q, $v) => $q->where('user_id', $v))
            ->when($request->date, fn($q, $v) => $q->whereDate('date', $v))
            ->when(
                $request->user_name,
                fn($q, $v) =>
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$v%"))
            )
            ->when(
                $request->activity_name,
                fn($q, $v) =>
                $q->whereHas('activity', fn($a) => $a->where('name', 'like', "%$v%"))
            );

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('user_name', fn($row) => optional($row->user)->name ?? '-')
            ->addColumn('activity_name', fn($row) => optional($row->activity)->name ?? '-')
            ->editColumn('status', fn($row) => $row->value ? '✅ Done' : '❌ Missed')
            ->editColumn('note', fn($row) => $row->note ?? '-')
            ->editColumn('created_at', fn($row) => $row->created_at->format('d M Y H:i'))
            ->make(true);
    }


    /**
     * Display the specified resource.
     */
    public function show(YaumiLog $yaumiLog)
    {
        return view('admin.yaumi-logs.show', compact('yaumiLog'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(YaumiLog $yaumiLog)
    {
        $yaumiLog->delete();

        return redirect()
            ->route('admin.yaumi-logs.index')
            ->with('success', 'Log deleted successfully.');
    }
}
