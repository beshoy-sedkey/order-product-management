<?php

namespace App\Services\Filters\Elements;

use App\Services\Filters\Filters;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProductFilters extends Filters
{

    public function name($value): Builder
    {
        return $this->builder->where('name', 'LIKE', '%' . $value . '%');
    }

    public function price($value): Builder
    {
        return $this->builder->where('price', 'LIKE', "% . $value . %");
    }
}
