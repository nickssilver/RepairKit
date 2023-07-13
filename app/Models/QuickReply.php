<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class QuickReply extends Model
{
    use Filterable;

    protected $fillable = ['name', 'body'];
}
