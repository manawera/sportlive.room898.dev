<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password',
        'role_id', 'mac_ethernet', 'mac_wifi',
        'vip_key', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function loginLogs()
    {
        return $this->hasMany(LoginLog::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public static function isMacDuplicate(String $ethernet, String $wifi)
    {
    	if (($ethernet == "" || $ethernet == "none") && ($wifi == "" || $wifi == "none"))
    		return true;

    	if (!($ethernet == "" || $ethernet == "none")) {
    		$ethCheck = User::where('mac_ethernet', $ethernet)
                ->first();

            if ($ethCheck)
            	return true;
    	}

    	if (!($wifi == "" || $wifi == "none")) {
    		$wifiCheck = User::where('mac_wifi', $wifi)
    			->first();

    		if ($wifiCheck)
    			return true;
    	}

    	return false;
    }
}
