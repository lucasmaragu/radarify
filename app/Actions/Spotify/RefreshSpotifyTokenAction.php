<?php

namespace App\Actions\Spotify;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RefreshSpotifyTokenAction
{
    public function execute(User $user): bool
    {
        if (!$user->spotify_refresh_token) {
            return false;
        }

        $response = Http::asForm()->withBasicAuth(
            config('services.spotify.client_id'),
            config('services.spotify.client_secret')
        )->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $user->spotify_refresh_token,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            
            $user->update([
                'spotify_access_token' => $data['access_token'],
                'spotify_refresh_token' => $data['refresh_token'] ?? $user->spotify_refresh_token,
            ]);

            return true;
        }

        Log::error('Error refrescando token de Spotify para el usuario ' . $user->id, $response->json());
        
        return false;
    }
}