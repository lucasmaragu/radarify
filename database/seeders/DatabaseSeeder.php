<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Playback;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(50)
            ->has(Playback::factory())
            ->create();
    }
}