<?php

namespace Database\Factories;

use App\Models\TourJob;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tour_job_id' => TourJob::factory(),
            'guide_id' => User::factory()->guide(),
            'status' => fake()->randomElement(['pending', 'shortlisted', 'accepted', 'rejected']),
            'cover_letter' => fake()->optional(0.5)->paragraph(),
            'applied_at' => now(),
        ];
    }
}
