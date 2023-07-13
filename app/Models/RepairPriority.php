<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RepairPriority extends Model
{

    protected $fillable = ['name', 'value', 'extra_charge'];

    /**
     * Repair order information linked to current priority
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
