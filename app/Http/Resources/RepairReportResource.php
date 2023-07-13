<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepairReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $order = [
            'name'                => $this->name,
            'tracking'            => $this->tracking,
            'total_charges'       => $this->total_charges,
            'sub_total'           => $this->sub_total,
            'profit'              => $this->profit,
            'tax'                 => $this->tax,
            'cost'                => $this->total_cost,
            'additional_amount'   => $this->additional_amount,
            'due'                 => $this->dueAmount(),
            'priority'            => new RepairPriorityResource($this->repairPriority),
            'status'              => new RepairStatusResource($this->repairStatus),
            'payment_status'      => $this->payment_status,
            'is_device_collected' => $this->is_device_collected,
        ];
        return $order;
    }
}
