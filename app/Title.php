<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $fillable = [
        'name',
        'name_local',
        'kind_id',
        'genre_id',
        'episode_of_id',
        'season',
        'episode',
        'series_started_year',
        'series_ended_year',
        'poster_url',
        'stream_url',
        'stream_url_en',
        'protect_id',
        'active',
    ];

    public function kind()
    {
        return $this->belongsTo(Kind::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    // public function episodes()
    // {
    //     return $this->hasMany(Title::class, 'episode_of_id');
    // }
}
