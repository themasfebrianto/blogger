<?php

namespace App\Http\Controllers\Api;

use App\Models\YaumiStreak;
use App\Http\Requests\Yaumi\YaumiStreaks\StoreYaumiStreakRequest;
use App\Http\Requests\Yaumi\YaumiStreaks\UpdateYaumiStreakRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Throwable;

class YaumiStreakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = YaumiStreak::query();

        if ($request->has('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->has('activity_id')) {
            $query->where('activity_id', $request->input('activity_id'));
        }

        $streaks = $query->orderByDesc('current_streak')->get();

        return response()->json([
            'status' => 'success',
            'data' => $streaks,
        ]);
    }

    /**
     * Store a newly created streak or update an existing one.
     */
    public function store(StoreYaumiStreakRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $streak = YaumiStreak::firstOrCreate(
                [
                    'user_id' => $data['user_id'],
                    'activity_id' => $data['activity_id'],
                ],
                [
                    'current_streak' => 0,
                    'longest_streak' => 0,
                    'last_logged_date' => null,
                ]
            );

            $today = Carbon::parse($data['date']);
            $lastLogged = $streak->last_logged_date ? Carbon::parse($streak->last_logged_date) : null;

            if ($lastLogged && $lastLogged->diffInDays($today) === 1) {
                // lanjut streak
                $streak->current_streak += 1;
            } elseif (!$lastLogged || $lastLogged->diffInDays($today) > 1) {
                // reset streak
                $streak->current_streak = 1;
            }

            // update longest streak jika perlu
            if ($streak->current_streak > $streak->longest_streak) {
                $streak->longest_streak = $streak->current_streak;
            }

            $streak->last_logged_date = $today;
            $streak->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Streak updated successfully.',
                'data' => $streak,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update streak.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified streak.
     */
    public function show(YaumiStreak $yaumiStreak): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $yaumiStreak,
        ]);
    }

    /**
     * Update a streak manually (admin use).
     */
    public function update(UpdateYaumiStreakRequest $request, YaumiStreak $yaumiStreak): JsonResponse
    {
        $yaumiStreak->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Streak updated successfully.',
            'data' => $yaumiStreak,
        ]);
    }

    /**
     * Remove a streak.
     */
    public function destroy(YaumiStreak $yaumiStreak): JsonResponse
    {
        $yaumiStreak->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Streak deleted successfully.',
        ]);
    }
}
