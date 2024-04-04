<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'attachments' => null, // Adjust as needed
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'status_id' => function () {
                return \App\Models\Status::factory()->create()->id;
            },
            // Define other attributes as needed
        ];
    }
}
