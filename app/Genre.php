<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
        'name',
    ];

    public function titles()
    {
        return $this->hasMany(Title::class);
    }
}
