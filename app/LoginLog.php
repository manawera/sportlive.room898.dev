<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'user_id', 'user_agent', 'ipaddress', 'logged_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
