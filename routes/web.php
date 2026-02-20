<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SpotifyAuthController;
use App\Http\Controllers\Spotify\SyncPlaybackController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Radar\RadarIndexController;
use App\Http\Controllers\Radar\RadarSyncController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('auth/spotify')->name('spotify.')->group(function () {
    Route::get('redirect', [SpotifyAuthController::class, 'redirect'])->name('redirect');
    Route::get('callback', [SpotifyAuthController::class, 'callback'])->name('callback');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/spotify/sync-playback', SyncPlaybackController::class)
    ->middleware('auth')
    ->name('spotify.sync-playback');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/radar', RadarIndexController::class)->name('radar.index');
    Route::get('/radar/sync', RadarSyncController::class)->name('radar.sync');
});

require __DIR__.'/auth.php';
