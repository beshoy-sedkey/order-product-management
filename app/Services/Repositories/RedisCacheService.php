<?php
namespace App\Services\Repositories;

use Illuminate\Support\Facades\Cache;
use App\Services\Repositories\CacheServiceInterface;

class RedisCacheService implements CacheServiceInterface
{
    private const DEFAULT_TTL = 3600; // 1 hour

    public function remember(string $key, int $ttl = self::DEFAULT_TTL, callable $callback)
    {
        return Cache::store('redis')->remember($key, $ttl, $callback);
    }

    public function forget(string $key): void
    {
        Cache::forget($key);
    }

    public function flush(): void
    {
        Cache::flush();
    }
}
