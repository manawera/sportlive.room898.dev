<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Live extends Model
{
    protected $fillable = [
        'name', 'channel_number', 'sort', 'logo_url',
        'stream_url', 'protect_id', 'tv_genre_id', 'active'
    ];

    public function genre()
    {
        return $this->belongsTo(TvGenre::class);
    }

    public function protect()
    {
        return $this->belongsTo(Protect::class);
    }
}
