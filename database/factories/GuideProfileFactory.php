<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuideProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->guide(),
            'license_no' => 'TG-' . fake()->numerify('####'),
            'experience_years' => fake()->numberBetween(1, 20),
            'skills' => fake()->randomElements(['City Tours', 'Nature Trails', 'Cultural Tours', 'Adventure', 'Historical', 'Food Tours', 'Island Hopping'], 3),
            'languages' => fake()->randomElements(['Malay', 'English', 'Mandarin', 'Arabic', 'Japanese', 'Korean', 'Thai'], 2),
            'social_links' => ['facebook' => 'https://facebook.com/' . fake()->userName()],
            'bio' => fake()->paragraph(),
        ];
    }
}
