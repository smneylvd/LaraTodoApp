<?php

namespace Database\Factories;

use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StatusFactory extends Factory
{
    protected $model = Status::class;

    public function definition()
    {
        $title = $this->faker->word;
        return [
            'title' => $title,
            'slug' => Str::slug($title),
        ];
    }
}
