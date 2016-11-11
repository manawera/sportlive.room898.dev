<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
    ];

    public function cards()
    {
    	return $this->hasMany(Card::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
