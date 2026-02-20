<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'spotify_id',
        'avatar',
        'spotify_access_token',
        'spotify_refresh_token',
    ];

    protected $hidden = [
        'spotify_access_token',
        'spotify_refresh_token',
    ];

    public function location(): HasOne
    {
        return $this->hasOne(Location::class);
    }

    public function playback(): HasOne
    {
        return $this->hasOne(Playback::class);
    }
}