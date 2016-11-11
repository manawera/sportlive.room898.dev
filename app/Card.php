<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'topup_type_id', 'package_id', 'plan_id', 'card_number',
        'transaction_id', 'amount', 'status', 'quantity', 'expired_at', 'user_id'
    ];

    public function topupType()
    {
        return $this->belongsTo(TopupType::class);
    }

    public function package()
    {
    	return $this->belongsTo(Package::class);
    }

    public function plan()
    {
    	return $this->belongsTo(Plan::class);
    }

    public function subscriptions()
    {
    	return $this->hasMany(Subscription::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function isValid($card_number)
    {
        $card = Card::where('card_number', $card_number)
                ->where('status', 0)
                ->first();

        if ($card)
            return true;
        return false;
    }
}
