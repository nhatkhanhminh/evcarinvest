<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'withdraw_information' => 'object'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userCoinBalance()
    {
        return $this->belongsTo(UserCoinBalance::class, 'user_coin_balance_id');
    }

    public function scopePending()
    {
        return $this->where('status', 0);
    }

    public function scopeApproved()
    {
        return $this->where('status', 1);
    }

    public function scopeRejected()
    {
        return $this->where('status', 2);
    }
}
