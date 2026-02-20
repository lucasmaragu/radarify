<?php

namespace App\Http\Controllers\Radar;

use App\Http\Controllers\Controller;
use App\Actions\Radar\GetNearbyPlaybacksAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RadarSyncController extends Controller
{
    public function __invoke(Request $request, GetNearbyPlaybacksAction $action): JsonResponse
    {
        $playbacks = $action->execute($request->user(), 100);

        return response()->json([
            'playbacks' => $playbacks
        ]);
    }
}