<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class DeviceFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    /**
     * Device dataTable search query
     *
     * @param mixed $search query
     *
     * @return DeviceFilter
     */
    public function search($search): DeviceFilter
    {
        return $this->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('model', 'LIKE', '%' . $search . '%');
    }
}
