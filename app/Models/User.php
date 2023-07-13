<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Storage;

class User extends Authentication
{
    use HasApiTokens, Notifiable, Filterable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'status',
        'password',
        'role_id',
        'phone',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Return user data
     *
     * @return BelongsTo
     */
    public function userRole(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'role_id');
    }

    /**
     * User avatar url
     *
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar
        ? Storage::disk('public')->url($this->avatar)
        : 'gravatar';
    }

    /**
     * Repair orders by user
     *
     * @return HasMany
     */
    public function repairOrders(): HasMany
    {
        return $this->hasMany(RepairOrder::class);
    }

    /**
     * User default avatar
     *
     * @return string
     */
    public function getGravatar(): string
    {
        return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?s=80&d=retro';
    }

    /**
     * Repair logs created by user
     *
     * @return HasMany
     */
    public function repairLogs(): HasMany
    {
        return $this->hasMany(RepairLog::class);
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
