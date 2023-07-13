<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class RepairOrder extends Model
{
    use Filterable, Notifiable;

    protected $fillable = [
        'name',
        'tracking',
        'uuid',
        'email',
        'phone',
        'serial_number',
        'address',
        'sub_total',
        'profit',
        'tax',
        'total_charges',
        'brand_id',
        'device_id',
        'repair_priority_id',
        'diagnostics',
        'pre_paid',
        'payment_status',
        'payment_info',
        'user_id',
        'total_cost',
        'brand_info',
        'device_info',
        'defects_info',
        'is_manual',
        'is_device_collected',
        'additional_amount',
        'send_notification',
        'is_archive',
        'is_lock',
        'has_warranty',
    ];

    protected $casts = [
        'is_manual' => 'boolean',
        'is_device_collected' => 'boolean',
        'brand_info' => 'json',
        'device_info' => 'json',
        'defects_info' => 'json',
        'send_notification' => 'boolean',
        'is_archive' => 'boolean',
        'is_lock' => 'boolean',
        'has_warranty' => 'boolean',
    ];

    /**
     * Setting default route key
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Gives due amount
     *
     * @return float
     */
    public function dueAmount($pre_paid = null): float
    {
        $amoutWithAddional = $this->total_charges + $this->additional_amount;
        return $pre_paid
        ? $amoutWithAddional - $pre_paid
        : $amoutWithAddional - $this->pre_paid;
    }

    /**
     * Repair logs for this repair order
     *
     * @return HasMany
     */
    public function repairLogs(): HasMany
    {
        return $this->hasMany(RepairLog::class)->latest();
    }

    /**
     * Current repair status
     *
     * @return BelongsTo
     */
    public function repairStatus(): BelongsTo
    {
        return $this->belongsTo(RepairStatus::class);
    }

    /**
     * Issues attached to repair order for fixing
     *
     * @return BelongsToMany
     */
    public function defects(): BelongsToMany
    {
        return $this->belongsToMany(Defect::class);
    }

    /**
     * Repairing priority level
     *
     * @return BelongsTo
     */
    public function repairPriority(): BelongsTo
    {
        return $this->belongsTo(RepairPriority::class);
    }

    /**
     * Repairable device brand
     *
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Repairable device information
     *
     * @return BelongsTo
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * Technician assigned to repair order
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function routeNotificationForNexmo()
    {
        return $this->phone;
    }

    public function routeNotificationForTwilio()
    {
        return $this->phone;
    }
}
