<?php

namespace App\Http\Controllers\Api;

use App\Models\YaumiLog;
use App\Http\Requests\Yaumi\YaumiLogs\StoreYaumiLogRequest;
use App\Http\Requests\Yaumi\YaumiLogs\UpdateYaumiLogRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class YaumiLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = YaumiLog::with('activity');

        if ($request->has('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->has('date')) {
            $query->whereDate('date', $request->input('date'));
        }

        $logs = $query->orderByDesc('date')->get();

        return response()->json([
            'status' => 'success',
            'data' => $logs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreYaumiLogRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            // Jika user sudah punya log di tanggal & activity sama, update saja
            $log = YaumiLog::updateOrCreate(
                [
                    'user_id' => $data['user_id'],
                    'activity_id' => $data['activity_id'],
                    'date' => $data['date'],
                ],
                [
                    'value' => $data['value'],
                    'note' => $data['note'] ?? null,
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Log saved successfully.',
                'data' => $log,
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save log.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(YaumiLog $yaumiLog): JsonResponse
    {
        $yaumiLog->load('activity');

        return response()->json([
            'status' => 'success',
            'data' => $yaumiLog,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateYaumiLogRequest $request, YaumiLog $yaumiLog): JsonResponse
    {
        try {
            $yaumiLog->update($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Log updated successfully.',
                'data' => $yaumiLog,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update log.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(YaumiLog $yaumiLog): JsonResponse
    {
        try {
            $yaumiLog->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Log deleted successfully.',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete log.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
