<?php

namespace App\Http\Controllers\Spotify;

use App\Http\Controllers\Controller;
use App\Actions\Spotify\SyncUserPlaybackAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SyncPlaybackController extends Controller
{
    public function __invoke(Request $request, SyncUserPlaybackAction $action): JsonResponse
    {
        $playback = $action->execute($request->user());

        return response()->json($playback);
    }
}