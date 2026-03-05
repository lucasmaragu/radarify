<?php

namespace App\Actions\Radar;

use App\Models\Playback;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class GetNearbyPlaybacksAction
{
    public function execute(User $user, int $radiusInMeters = 100000000000): Collection
    {
        if (!$user->location) {
            return new Collection();
        }

        return Playback::with(['user.location'])
            ->select('playbacks.*')
            ->join('locations', 'playbacks.user_id', '=', 'locations.user_id')
            ->where('playbacks.is_playing', true)
            ->where('playbacks.user_id', '!=', $user->id)
            ->whereRaw('ST_DWithin(
                locations.coordinates, 
                (SELECT coordinates FROM locations WHERE user_id = ?), 
                ?
            )', [$user->id, $radiusInMeters])
            ->selectRaw('
                ST_Distance(
                    locations.coordinates, 
                    (SELECT coordinates FROM locations WHERE user_id = ?)
                ) as distance_meters
            ', [$user->id])
            ->orderBy('distance_meters')
            ->get();
    }
}