<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class DefectFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    /**
     * DataTable search query
     *
     * @param mixed $search query
     *
     * @return DefectFilter
     */
    public function search($search): DefectFilter
    {
        return $this->where('title', 'LIKE', '%' . $search . '%');
    }
}
