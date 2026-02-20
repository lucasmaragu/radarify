<?php

namespace App\Actions\Location;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateUserLocationAction
{
    public function execute(User $user, float $lat, float $lng): void
    {
        $user->location()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'coordinates' => DB::raw("ST_GeomFromText('POINT({$lng} {$lat})', 4326)")
            ]
        );
    }
}