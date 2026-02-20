<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Actions\Auth\ProcessSpotifyCallbackAction;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\RedirectResponse;

class SpotifyAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('spotify')
            ->scopes(['user-read-currently-playing', 'user-read-playback-state'])
            ->redirect();
    }

    public function callback(ProcessSpotifyCallbackAction $action): RedirectResponse
    {
        $spotifyUser = Socialite::driver('spotify')->user();

        $user = $action->execute($spotifyUser);

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }
}