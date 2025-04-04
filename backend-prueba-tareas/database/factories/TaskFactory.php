<?php

namespace Database\Factories;

use App\Task\Infrastructure\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'state' => $this->faker->randomElement(['pending', 'completed']),
            'user_id' => \App\Auth\Infrastructure\Models\User::factory()
        ];
    }
} 