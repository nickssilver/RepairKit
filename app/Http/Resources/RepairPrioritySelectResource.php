<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepairPrioritySelectResource extends JsonResource
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
            'id'           => $this->id,
            'name'         => $this->name,
            'value'        => $this->value,
            'extra_charge' => $this->extra_charge,
        ];
    }
}
