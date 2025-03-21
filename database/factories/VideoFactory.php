<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Video::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'url' => 'https://www.youtube.com/watch?v=' . $this->faker->lexify('???????????'),
            'published_at' => now(),
            'previous' => null,
            'next' => null,
            'series_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => User::first()->id,
        ];
    }
}
