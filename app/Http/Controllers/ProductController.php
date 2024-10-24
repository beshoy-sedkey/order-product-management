<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Repositories\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{


    public function index(Request $request, ProductServiceInterface $productService)
    {
        $products = $productService->getPaginatedProducts($request);
        return ProductResource::collection($products);
    }
}
