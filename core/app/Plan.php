<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the miner that owns the Plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function miner()
    {
        return $this->belongsTo(Miner::class);
    }

    public function getPeriodUnitTextAttribute()
    {
        switch ($this->period_unit) {
            case 2:
                return 'Year';
            case 1:
                return 'Month';

            default:
                return 'Day';
        }
    }

    public function getReturnPerDayAttribute() {
        if(!$this->max_return_per_day){
            return getAmount($this->min_return_per_day,8);
        }else{
            return getAmount($this->min_return_per_day,8).' - '.getAmount($this->max_return_per_day,8);
        }
    }

    public function getSpeedUnitTextAttribute()
    {
        switch ($this->speed_unit) {
            case 8:
                return 'Year';
            case 7:
                return 'Zhash/s';
            case 6:
                return 'Ehash/s';
            case 5:
                return 'Phash/s';
            case 4:
                return 'Thash/s';
            case 3:
                return 'Ghash/s';
            case 2:
                return 'Mhash/s';
            case 1:
                return 'Khash/s';

            default:
                return 'hash/s';
        }

    }

}
