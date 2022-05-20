<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Miner extends Model
{
    protected $guarded = ['id'];

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
    public function activePlans()
    {
        return $this->hasMany(Plan::class)->where('status', 1);
    }

    public function userCoinBalances()
    {
        return $this->hasOne(UserCoinBalance::class, 'coin_code', 'coin_code');
    }
}
