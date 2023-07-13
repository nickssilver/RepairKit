<?php

namespace App\Imports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DevicesImport implements ToModel, WithValidation, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Device([
            'brand_id' => request()->get('brand_id'),
            'name' => $row['name'],
            'model' => $row['model'],
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:devices,name',
            'model' => [
                'required',
                'string',
            ],
        ];
    }
}
