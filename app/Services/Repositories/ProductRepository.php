<?php

namespace App\Services\Repositories;

use App\Models\Product;
use App\Services\Filters\Elements\ProductFilters;
use App\Services\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductRepository implements ProductRepositoryInterface
{
    private Product $model;

    protected $filters;

    public function __construct(Product $model , ProductFilters $filters)
    {
        $this->model = $model;
        $this->filters = $filters;
    }

    public function getPaginated(Request $request)
    {
        return $this->model
            ->filter($this->filters)
            ->dynamicPagination();
    }

    public function find(int $id): Product
    {
        return $this->model->find($id);
    }
}
