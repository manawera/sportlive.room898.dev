<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kind extends Model
{
    protected $fillable = [
        'name',
    ];

    public function titles()
    {
        return $this->hasMany(Title::class);
    }
}
