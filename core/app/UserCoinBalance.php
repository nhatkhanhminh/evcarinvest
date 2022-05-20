<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCoinBalance extends Model
{
    protected $guarded = ['id'];


    public function miner()
    {
        return $this->belongsTo(Miner::class, 'coin_code', 'coin_code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
