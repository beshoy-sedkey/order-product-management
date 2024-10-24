<?php
namespace App\Services\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface ProductServiceInterface
{
    public function getPaginatedProducts(Request $request): LengthAwarePaginator;
    public function clearCache(): void;
}
