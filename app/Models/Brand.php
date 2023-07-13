<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{

    protected $fillable = ['name'];

    /**
     * Repair orders
     *
     * @return HasMany
     */
    public function repairOrders(): HasMany
    {
        return $this->hasMany(RepairOrder::class);
    }

    /**
     * Devices under brand
     *
     * @return HasMany
     */
    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    /**
     * Check information is being used or not
     *
     * @return bool
     */
    public function beingUsed(): bool
    {
        return $this->devices->count() || $this->repairOrders->count();
    }
}
