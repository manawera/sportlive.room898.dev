<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Subscription extends Model
{
    protected $fillable = [
        'card_id', 'package_id', 'started_at', 'ended_at', 'status', 'user_id',
    ];

    public function card()
    {
    	return $this->belongsTo(Card::class);
    }

    public function package()
    {
    	return $this->belongsTo(Package::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    // Check last package exired before get streaming url and before new subscription
    public static function isSubscription($user_id, $package_id)
    {
        $subscription = Subscription::where('user_id', $user_id)
                            ->where('package_id', $package_id)
                            ->where('status', 1)
                            ->orderBy('id', 'desc')
                            ->first();

        if ($subscription) {
            if ($subscription->ended_at > Carbon::now())
                return true;
            return false;
        } else {
            return false;
        }
    }

}
