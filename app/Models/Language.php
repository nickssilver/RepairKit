<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = ['name', 'locale'];

    /**
     * Determines if default.
     *
     * @return     bool  True if default, False otherwise.
     */
    public function isDefault(): bool
    {
        return config('app.locale') === $this->locale;
    }

    /**
     * Determines if prime.
     *
     * @return     bool  True if prime, False otherwise.
     */
    public function isPrime(): bool
    {
        return 1 === $this->id;
    }
}
