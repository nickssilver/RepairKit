<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Storage;

class Device extends Model
{
    use Filterable;

    protected $fillable = ['name', 'model', 'brand_id', 'avatar'];

    /**
     * Brand
     *
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Defects or service attached to device
     *
     * @return HasMany
     */
    public function defects(): HasMany
    {
        return $this->hasMany(Defect::class);
    }

    /**
     * Repair orders to device
     *
     * @return HasMany
     */
    public function repairOrders(): HasMany
    {
        return $this->hasMany(RepairOrder::class);
    }

    /**
     * Device avatar
     *
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar
        ? Storage::disk('public')->url($this->avatar)
        : asset('images/default/icon.png');
    }

    /**
     * Check information is being used or not
     *
     * @return bool
     */
    public function beingUsed(): bool
    {
        return $this->defects->count() || $this->repairOrders->count();
    }
}
