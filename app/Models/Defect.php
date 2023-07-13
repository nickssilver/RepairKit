<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Defect extends Model
{
    use Filterable;

    protected $fillable = ['title', 'price', 'cost', 'required_time', 'device_id'];

    /**
     * Defect device
     *
     * @return BelongsTo
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * Repair orders belongs to this defect
     *
     * @return BelongsToMany
     */
    public function repairOrders(): BelongsToMany
    {
        return $this->belongsToMany(RepairOrder::class);
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
