<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgencyProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->agency(),
            'company_name' => fake()->company() . ' Travel',
            'motac_reg_no' => 'MOTAC-' . fake()->numerify('######'),
            'contact_person' => fake()->name(),
            'company_address' => fake()->address(),
            'company_phone' => fake()->phoneNumber(),
        ];
    }
}
