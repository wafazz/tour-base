<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourJobFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('+1 week', '+3 months');
        $end = fake()->dateTimeBetween($start, (clone $start)->modify('+2 weeks'));

        return [
            'agency_id' => User::factory()->agency(),
            'title' => fake()->randomElement(['KL City Tour', 'Langkawi Island Hop', 'Penang Heritage Walk', 'Cameron Highlands Day Trip', 'Melaka Historical Tour', 'Sabah Wildlife Safari', 'Taman Negara Jungle Trek']),
            'description' => fake()->paragraphs(2, true),
            'requirements' => fake()->sentence(10),
            'type' => fake()->randomElement(['inbound', 'outbound']),
            'location' => fake()->randomElement(['Kuala Lumpur', 'Penang', 'Langkawi', 'Melaka', 'Sabah', 'Sarawak', 'Johor Bahru', 'Cameron Highlands']),
            'start_date' => $start,
            'end_date' => $end,
            'fee' => fake()->randomFloat(2, 200, 3000),
            'status' => 'active',
            'admin_approved_at' => now(),
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => 'pending', 'admin_approved_at' => null]);
    }
}
