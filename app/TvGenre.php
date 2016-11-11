<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TvGenre extends Model
{
    protected $fillable = [
        'name',
    ];

    public function lives()
    {
        return $this->hasMany(Live::class);
    }
}
