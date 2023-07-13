<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserRole extends Model
{
    use Filterable;

    protected $fillable = ['name', 'is_primary', 'permissions'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions' => 'json',
        'is_primary'  => 'boolean',
    ];

    /**
     * Get the users for the user role
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }

    /**
     * Checks requested gate's permission status
     *
     * @param mixed $gate gate key
     *
     * @return bool
     */
    public function checkPermission($gate): bool
    {
        if ($this->id < 2) {
            return true;
        }
        return $gate ? in_array($gate, $this->permissions) : false;
    }
}
