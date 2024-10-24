<?php

namespace App\Services\Repositories;

use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    protected $model;
    public function __construct(Order $model)
    {
        $this->model  = $model;
    }

    public function create(array $data): Order
    {
        return $this->model->create($data);
    }

    public function find(int $id , $with = []): Order
    {
        return $this->model->with($with)->find($id);
    }
}
