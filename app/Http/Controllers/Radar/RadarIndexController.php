<?php

namespace App\Http\Controllers\Radar;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class RadarIndexController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Radar/Index');
    }
}