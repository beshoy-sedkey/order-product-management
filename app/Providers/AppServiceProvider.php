<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Repositories\ProductService;
use App\Services\Repositories\ProductRepository;
use App\Services\Repositories\RedisCacheService;
use App\Services\Repositories\CacheServiceInterface;
use App\Services\Repositories\OrderRepository;
use App\Services\Repositories\OrderRepositoryInterface;
use App\Services\Repositories\ProductServiceInterface;
use App\Services\Repositories\ProductRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CacheServiceInterface::class, RedisCacheService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
