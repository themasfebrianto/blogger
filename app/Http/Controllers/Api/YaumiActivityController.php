<?php

namespace App\Http\Controllers\Api;

use App\Models\YaumiActivity;
use App\Http\Requests\Yaumi\YaumiActivities\StoreYaumiActivityRequest;
use App\Http\Requests\Yaumi\YaumiActivities\UpdateYaumiActivityRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class YaumiActivityController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = YaumiActivity::query();

        if ($request->has('active')) {
            $query->where('is_active', (bool) $request->boolean('active'));
        }

        $activities = $query->orderBy('order')->get();

        return response()->json([
            'status' => 'success',
            'data' => $activities,
        ]);
    }

    public function store(StoreYaumiActivityRequest $request): JsonResponse
    {
        try {
            $activity = YaumiActivity::create($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Activity created successfully.',
                'data' => $activity,
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create activity.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(YaumiActivity $yaumiActivity): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $yaumiActivity,
        ]);
    }

    public function update(UpdateYaumiActivityRequest $request, YaumiActivity $yaumiActivity): JsonResponse
    {
        try {
            $yaumiActivity->update($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Activity updated successfully.',
                'data' => $yaumiActivity,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update activity.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(YaumiActivity $yaumiActivity): JsonResponse
    {
        try {
            $yaumiActivity->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Activity deleted successfully.',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete activity.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
