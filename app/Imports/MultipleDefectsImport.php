<?php

namespace App\Imports;

use App\Models\Defect;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MultipleDefectsImport implements ToModel, WithHeadingRow, WithValidation
{

    protected $device;

    public function __construct($device)
    {
        $this->device = $device;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Defect([
            'device_id' => $this->device,
            'title' => $row['title'],
            'cost' => $row['cost'],
            'price' => $row['price'],
            'required_time' => $row['time'],
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
            ],
            'cost' => [
                'required',
                'numeric',
            ],
            'price' => [
                'required',
                'numeric',
            ],
            'time' => [
                'required',
            ],
        ];
    }
}
