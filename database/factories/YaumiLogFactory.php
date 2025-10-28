<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\YaumiLog;
use App\Models\YaumiActivity;
use App\Models\User;

class YaumiLogFactory extends Factory
{
    protected $model = YaumiLog::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'activity_id' => YaumiActivity::factory(),
            'date' => $this->faker->date(),
            'value' => $this->faker->numberBetween(1, 4),
            'note' => $this->faker->sentence,
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
