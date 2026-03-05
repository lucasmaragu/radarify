<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SpotifyAuthController;
use App\Http\Controllers\Spotify\SyncPlaybackController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Radar\RadarIndexController;
use App\Http\Controllers\Radar\RadarSyncController;
use App\Http\Controllers\Location\UpdateLocationController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [SpotifyAuthController::class, 'redirect'])->name('login');
});

Route::prefix('auth/spotify')->name('spotify.')->group(function () {
    Route::get('redirect', [SpotifyAuthController::class, 'redirect'])->name('redirect');
    Route::get('callback', [SpotifyAuthController::class, 'callback'])->name('callback');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', RadarIndexController::class)->name('radar.index');
    Route::get('/radar/sync', RadarSyncController::class)->name('radar.sync');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/spotify/sync-playback', SyncPlaybackController::class)->name('spotify.sync-playback');
    Route::post('/location/update', UpdateLocationController::class)->name('location.update');
});