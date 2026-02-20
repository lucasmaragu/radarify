<?php

namespace App\Actions\Auth;

use App\Models\User;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class ProcessSpotifyCallbackAction
{
    public function execute(SocialiteUser $spotifyUser): User
    {
        return User::updateOrCreate(
            ['spotify_id' => $spotifyUser->getId()],
            [
                'name' => $spotifyUser->getName() ?? $spotifyUser->getNickname(),
                'avatar' => $spotifyUser->getAvatar(),
                'spotify_access_token' => $spotifyUser->token,
                'spotify_refresh_token' => $spotifyUser->refreshToken,
            ]
        );
    }
}