<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Playback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'track_id',
        'track_name',
        'artist_name',
        'album_image_url',
        'is_playing',
    ];

    protected $casts = [
        'is_playing' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}