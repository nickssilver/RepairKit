<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Media extends Model
{

    protected $fillable = [
        'uuid',
        'name',
        'size',
        'mime',
        'extension',
        'disk',
        'path',
        'server_name',
        'user_id',
    ];

    /**
     * File url
     *
     * @return null|string
     */
    public function url():  ? string
    {
        if ('public' === $this->disk) {
            return Storage::disk($this->disk)->url($this->path . DIRECTORY_SEPARATOR . $this->server_name);
        }
        return null;
    }
}
