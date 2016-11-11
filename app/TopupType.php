<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopupType extends Model
{
    protected $fillable = [
        'name',
    ];

    public function cards()
    {
    	return $this->hasMany(Card::class);
    }
}
