<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
    ];

    public function cards()
    {
    	return $this->hasMany(Card::class);
    }
}
