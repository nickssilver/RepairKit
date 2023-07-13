<?php

namespace App\Http\Resources\Media;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'size'      => $this->size,
            'uuid'      => $this->uuid,
            'mime'      => $this->mime,
            'extension' => $this->extension,
            'url'       => $this->url(),
        ];
    }
}
