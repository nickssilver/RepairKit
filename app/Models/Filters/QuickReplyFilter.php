<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class QuickReplyFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    /**
     * Quick reply search operation
     *
     * @param mixed $search query
     *
     * @return QuickReplyFilter
     */
    public function search($search): QuickReplyFilter
    {
        return $this->where('name', 'LIKE', '%' . $search . '%');
    }
}
