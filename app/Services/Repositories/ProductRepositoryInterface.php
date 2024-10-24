<?php
namespace App\Services\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface{
    public function getPaginated(Request $request);
    public function find(int $id): Product;
}
