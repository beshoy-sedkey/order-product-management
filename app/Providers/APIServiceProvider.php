<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class APIServiceProvider extends ServiceProvider
{

    protected const ITEMS_PAGINATION = 25;
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $defaultPagination = self::ITEMS_PAGINATION;
        Builder::macro('dynamicPagination', function () use ($defaultPagination) {
            return $this->paginate(
                Request::input('per_page', $defaultPagination)
            );
        });
    }
}
