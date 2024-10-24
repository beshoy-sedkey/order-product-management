<?php
namespace App\Services\Repositories;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\Repositories\CacheServiceInterface;
use App\Services\Repositories\ProductServiceInterface;
use App\Services\Repositories\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Redis;

class ProductService implements ProductServiceInterface
{
    private const CACHE_TTL = 3600;
    private const CACHE_PREFIX = 'products_page_';

    private ProductRepositoryInterface $repository;
    private CacheServiceInterface $cache;

    public function __construct(
        ProductRepositoryInterface $repository,
        CacheServiceInterface $cache
    ) {
        $this->repository = $repository;
        $this->cache = $cache;
    }

    public function getPaginatedProducts(Request $request): LengthAwarePaginator
    {
        $cacheKey = $this->generateCacheKey($request);
        return $this->cache->remember(
            $cacheKey,
            self::CACHE_TTL,
            fn() => $this->repository->getPaginated($request)
        );
    }

    public function clearCache(): void
    {
        $this->cache->flush();
    }

    private function generateCacheKey(Request $request): string
    {
        $params = array_filter($request->all(), function ($value) {
            return $value !== '' && $value !== null;
        });

        ksort($params);

        return self::CACHE_PREFIX . md5(http_build_query($params));
    }


    private function debugCacheKey(string $cacheKey): void
    {
        // Check if key exists
        $exists = Redis::exists($cacheKey);

        // Get TTL if key exists
        $ttl = $exists ? Redis::ttl($cacheKey) : null;

        // Get raw data
        $rawData = Redis::get($cacheKey);

        dd([
            'cache_key' => $cacheKey,
            'exists' => $exists,
            'ttl' => $ttl,
            'raw_data' => $rawData,
            'all_keys' => Redis::keys('*'),
            'request_params' => request()->all()
        ]);
    }
}
