<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\DatatableBuilders;
use App\Helpers\FilterBuilders;
use App\Models\YaumiStreak;
use App\Models\User;
use Illuminate\Http\Request;

class YaumiStreakController extends Controller
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

        return view('admin.yaumi-streaks.index', compact('filters', 'datatable'));
    }

    protected function getDatatableFilters()
    {
        $users = User::orderBy('name')->get();

        return FilterBuilders::make()
            ->selectFromModel('user_id', 'All Users', $users)
            ->get();
    }

    protected function datatableConfig()
    {
        return DatatableBuilders::make('yaumi-streaks-table')
            ->ajax(route('admin.yaumi-streaks.index'))
            ->addColumn('#', 'DT_RowIndex', false, false)
            ->addColumn('User', 'user_name')
            ->addColumn('Current Streak', 'current_streak')
            ->addColumn('Longest Streak', 'longest_streak')
            ->addColumn('Last Activity Date', 'last_activity_date')
            ->addColumn('Updated At', 'updated_at')
            ->order(5, 'desc')
            ->build();
    }

    protected function getDatatableData(Request $request)
    {
        $query = YaumiStreak::query()
            ->with('user')
            ->when($request->user_id, fn($q, $v) => $q->where('user_id', $v))
            ->when(
                $request->user_name,
                fn($q, $v) =>
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$v%"))
            );

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('user_name', fn($row) => optional($row->user)->name ?? '-')
            ->editColumn('current_streak', fn($row) => $row->current_streak . ' 🔥')
            ->editColumn('longest_streak', fn($row) => $row->longest_streak)
            ->editColumn('last_activity_date', fn($row) => $row->last_activity_date?->format('d M Y') ?? '-')
            ->editColumn('updated_at', fn($row) => $row->updated_at->format('d M Y H:i'))
            ->rawColumns(['action'])
            ->make(true);
    }


    /**
     * Display the specified resource.
     */
    public function show(YaumiStreak $yaumiStreak)
    {
        return view('admin.YaumiStreaks.show', compact('yaumiStreak'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(YaumiStreak $yaumiStreak)
    {
        $yaumiStreak->delete();

        return redirect()
            ->route('admin.YaumiStreaks.index')
            ->with('success', 'Yaumi streak deleted successfully.');
    }
}
