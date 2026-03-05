<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- 1. Añade esta línea arriba

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any a  pplication services.
     */
    public function boot(): void
    {
        if (config('app.env') !== 'production') {
            URL::forceScheme('https');
        }
        \Illuminate\Support\Facades\Event::listen(
            \SocialiteProviders\Manager\SocialiteWasCalled::class,
            [\SocialiteProviders\Spotify\SpotifyExtendSocialite::class, 'handle']
        );
        Vite::prefetch(concurrency: 3);
    }
}
