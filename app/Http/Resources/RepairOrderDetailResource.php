<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RepairOrderDetailResource extends JsonResource
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
            'address' => $this->address,
            'tracking' => $this->tracking,
            'serial_number' => $this->serial_number,
            'total_charges' => $this->total_charges,
            'sub_total' => $this->sub_total,
            'profit' => $this->profit,
            'tax' => $this->tax,
            'pre_paid' => $this->pre_paid,
            'additional_amount' => $this->additional_amount,
            'is_archive' => $this->is_archive,
            'is_lock' => $this->is_lock,
            'has_warranty' => $this->has_warranty,
            'due' => $this->dueAmount(),
            'priority' => new RepairPriorityResource($this->repairPriority),
            'user_id' => $this->user_id,
            'status' => new RepairStatusResource($this->repairStatus),
            'payment_status' => $this->payment_status,
            'payment_info' => $this->payment_info,
            'diagnostics' => $this->diagnostics,
            'is_manual' => $this->is_manual,
            'is_device_collected' => $this->is_device_collected,
            'send_notification' => $this->send_notification,
            'created_at' => $this->created_at->format(config('app.app_date_format')),
            'updated_at' => $this->updated_at->format(config('app.app_date_format')),
        ];
        if ($this->is_manual) {
            $order['brand'] = $this->brand_info;
            $order['device'] = $this->device_info;
            $order['defects'] = $this->defects_info;
        } else {
            $order['brand'] = new BrandSelectResource($this->brand);
            $order['device'] = new DeviceAlongDefectResource($this->device);
            $order['defects'] = DefectDetailResource::collection($this->defects);
        }
        return $order;
    }
}
