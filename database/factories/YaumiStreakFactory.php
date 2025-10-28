<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\YaumiStreak;
use App\Models\User;

class YaumiStreakFactory extends Factory
{
    protected $model = YaumiStreak::class;

    public function definition()
    {
        $streak = $this->faker->numberBetween(1, 30);
        return [
            'user_id' => User::factory(),
            'start_date' => now()->subDays($streak),
            'end_date' => now(),
            'longest_streak' => $streak,
            'current_streak' => $streak,
        ];
    }
}
