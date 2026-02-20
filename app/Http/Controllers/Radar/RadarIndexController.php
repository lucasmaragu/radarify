<?php

namespace App\Http\Controllers\Radar;

use App\Http\Controllers\Controller;
use App\Actions\Radar\GetActivePlaybacksAction;
use Inertia\Inertia;
use Inertia\Response;

class RadarIndexController extends Controller
{
    public function __invoke(GetActivePlaybacksAction $action): Response
    {
        return Inertia::render('Radar/Index', [
            'initialPlaybacks' => $action->execute()
        ]);
    }
}