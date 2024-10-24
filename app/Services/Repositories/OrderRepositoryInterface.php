<?php
namespace App\Services\Repositories;

use App\Models\Order;

interface OrderRepositoryInterface{
     public function create(array $data): Order;
     public function find(int $id , $with = []) : Order;
}
