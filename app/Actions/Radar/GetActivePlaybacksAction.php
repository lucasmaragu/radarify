<?php

namespace App\Actions\Radar;

use App\Models\Playback;
use Illuminate\Database\Eloquent\Collection;

class GetActivePlaybacksAction
{
    public function execute(): Collection
    {
        return Playback::with('user')
            ->where('is_playing', true)
            ->orderBy('updated_at', 'desc')
            ->get();
    }
}