<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\YaumiActivity;

class YaumiActivityFactory extends Factory
{
    protected $model = YaumiActivity::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence,
            'icon' => 'fa-running',
            'order' => $this->faker->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
