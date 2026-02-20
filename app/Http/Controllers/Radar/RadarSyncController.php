<?php

namespace App\Http\Controllers\Radar;

use App\Http\Controllers\Controller;
use App\Actions\Radar\GetActivePlaybacksAction;
use Illuminate\Http\JsonResponse;

class RadarSyncController extends Controller
{
    public function __invoke(GetActivePlaybacksAction $action): JsonResponse
    {
        return response()->json([
            'playbacks' => $action->execute()
        ]);
    }
}