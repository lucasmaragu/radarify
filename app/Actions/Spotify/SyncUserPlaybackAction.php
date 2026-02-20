<?php

namespace App\Actions\Spotify;

use App\Models\User;
use App\Models\Playback;
use Illuminate\Support\Facades\Http;

class SyncUserPlaybackAction
{
    public function __construct(
        protected RefreshSpotifyTokenAction $refreshTokenAction
    ) {}

    public function execute(User $user): Playback
    {
        $response = $this->fetchFromSpotify($user->spotify_access_token);

        if ($response->status() === 401) {
            $refreshed = $this->refreshTokenAction->execute($user);
            
            if ($refreshed) {
                $response = $this->fetchFromSpotify($user->fresh()->spotify_access_token);
            }
        }
    
        if ($response->status() === 204 || $response->failed() || empty($response->json('item'))) {
            return $user->playback()->updateOrCreate(
                ['user_id' => $user->id],
                ['is_playing' => false]
            );
        }

        $data = $response->json();

        return $user->playback()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'track_id' => $data['item']['id'] ?? null,
                'track_name' => $data['item']['name'] ?? null,
                'artist_name' => $data['item']['artists'][0]['name'] ?? null,
                'album_image_url' => $data['item']['album']['images'][0]['url'] ?? null,
                'is_playing' => $data['is_playing'] ?? false,
            ]
        );
    }

    private function fetchFromSpotify(?string $token)
    {
        return Http::withToken($token)
            ->get('https://api.spotify.com/v1/me/player/currently-playing');
    }
}   