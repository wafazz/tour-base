<?php

namespace Database\Factories;

use App\Models\TourJob;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'agency_id' => User::factory()->agency(),
            'guide_id' => User::factory()->guide(),
            'tour_job_id' => TourJob::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->sentence(),
        ];
    }
}
