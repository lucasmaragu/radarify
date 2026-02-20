<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Actions\Location\UpdateUserLocationAction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UpdateLocationController extends Controller
{
    public function __invoke(Request $request, UpdateUserLocationAction $action): JsonResponse
    {
        $validated = $request->validate([
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        $action->execute($request->user(), $validated['latitude'], $validated['longitude']);

        return response()->json(['status' => 'success']);
    }
}