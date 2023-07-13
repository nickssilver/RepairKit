<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class RepairOrderPrintResource extends JsonResource
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
            'name' => $this->name,
            'email' => Str::mask($this->email, '*', 2, 3),
            'phone' => Str::mask($this->phone, '*', 2, 3),
            'address' => Str::mask($this->address, '*', 2, 5),
            'tracking' => $this->tracking,
            'serial_number' => $this->serial_number,
            'total_charges' => $this->total_charges,
            'sub_total' => $this->sub_total,
            'tax' => $this->tax,
            'pre_paid' => $this->pre_paid,
            'due' => $this->dueAmount(),
            'additional_amount' => $this->additional_amount,
            'priority' => new RepairPriorityResource($this->repairPriority),
            'status' => $this->repairStatus->body,
            'is_device_collected' => $this->is_device_collected,
            'is_manual' => $this->is_manual,
            'is_archive' => $this->is_archive,
            'is_lock' => $this->is_lock,
            'has_warranty' => $this->has_warranty,
            'created_at' => $this->created_at->format(config('app.app_date_format')),
            'updated_at' => $this->updated_at->format(config('app.app_date_format')),
        ];
        if ($this->is_manual) {
            $invoice['brand'] = $this->brand_info['name'];
            $invoice['device'] = $this->device_info;
            $invoice['defects'] = $this->defects_info;
        } else {
            $invoice['brand'] = $this->brand->name;
            $invoice['device'] = new DeviceAlongDefectResource($this->device);
            $invoice['defects'] = DefectDetailResource::collection($this->defects);
        }
        return $invoice;
    }
}
