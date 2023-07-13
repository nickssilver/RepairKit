<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepairOrderResource extends JsonResource
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
        $order = [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'tracking' => $this->tracking,
            'serial_number' => $this->serial_number,
            'total_charges' => $this->total_charges + $this->additional_amount,
            'defects' => count($this->defects),
            'priority' => new RepairPriorityResource($this->repairPriority),
            'status' => new RepairStatusResource($this->repairStatus),
            'assigned_to' => new UserAsTechnicianResource($this->user),
            'payment_status' => $this->dueAmount() > 0 ? false : true,
            'is_manual' => $this->is_manual,
            'is_device_collected' => $this->is_device_collected,
            'is_archive' => $this->is_archive,
            'is_lock' => $this->is_lock,
            'has_warranty' => $this->has_warranty,
            'created_at' => $this->created_at->format(config('app.app_date_format')),
            'updated_at' => $this->updated_at->format(config('app.app_date_format')),
        ];
        if ($this->is_manual) {
            $order['brand'] = $this->brand_info;
            $order['device'] = $this->device_info;
        } else {
            $order['brand'] = new BrandSelectResource($this->brand);
            $order['device'] = new DeviceAlongDefectResource($this->device);
        }
        return $order;
    }
}
