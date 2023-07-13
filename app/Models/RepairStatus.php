<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RepairStatus extends Model
{
    protected $fillable = ['body'];

    /**
     * Repair order information
     *
     * @return HasMany
     */
    public function repairOrders(): HasMany
    {
        return $this->hasMany(RepairOrder::class);
    }

    /**
     * Check information is being used or not
     *
     * @return bool
     */
    public function beingUsed(): bool
    {
        return $this->repairOrders->count();
    }
}
