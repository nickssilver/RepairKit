<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepairOrderTrackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request request
     *
     * @return array
     */
    public function toArray($request)
    {
        $invoice = [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'tracking' => $this->tracking,
            'serial_number' => $this->serial_number,
            'total_charges' => $this->total_charges,
            'tax' => $this->tax,
            'due' => $this->dueAmount(),
            'additional_amount' => $this->additional_amount,
            'priority' => new RepairPriorityResource($this->repairPriority),
            'status' => $this->repairStatus->body,
            'is_manual' => $this->is_manual,
            'is_device_collected' => $this->is_device_collected,
            'created_at' => $this->created_at->format(config('app.app_date_format')),
            'updated_at' => $this->updated_at->format(config('app.app_date_format')),
        ];

        if ($this->is_manual) {
            $invoice['brand'] = $this->brand_info['name'];
            $invoice['device'] = $this->device_info;
        } else {
            $invoice['brand'] = $this->brand->name;
            $invoice['device'] = new DeviceAlongDefectResource($this->device);
        }
        return $invoice;
    }
}
