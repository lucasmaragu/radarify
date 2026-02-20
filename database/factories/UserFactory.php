<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'spotify_id' => fake()->unique()->regexify('[A-Za-z0-9]{20}'), 
            'avatar' => 'https://i.pravatar.cc/150?u=' . fake()->uuid(), 
            'spotify_access_token' => fake()->regexify('[A-Za-z0-9]{50}'),
            'spotify_refresh_token' => fake()->regexify('[A-Za-z0-9]{50}'),
        ];
    }
}