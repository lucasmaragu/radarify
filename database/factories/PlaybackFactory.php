<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaybackFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 
            'track_id' => $this->faker->regexify('[A-Za-z0-9]{22}'),
            'track_name' => $this->faker->catchPhrase(),
            'artist_name' => $this->faker->name(),
            'album_image_url' => 'https://picsum.photos/seed/' . $this->faker->uuid() . '/300/300',
            'is_playing' => $this->faker->boolean(85), 
        ];
    }
}