<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class LocationFactory extends Factory
{
    public function definition(): array
    {
        $longitude = fake()->longitude(2.00, 2.30);
        $latitude = fake()->latitude(41.30, 41.45);

        return [
            'user_id' => User::factory(),
            'coordinates' => DB::raw("ST_SetSRID(ST_MakePoint({$longitude}, {$latitude}), 4326)"),
        ];
    }
}