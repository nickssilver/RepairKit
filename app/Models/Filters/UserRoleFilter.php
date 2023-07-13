<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class UserRoleFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    /**
     * User role search query
     *
     * @param mixed $search query
     *
     * @return UserRoleFilter
     */
    public function search($search): UserRoleFilter
    {
        return $this->where('name', 'LIKE', '%' . $search . '%');
    }
}
