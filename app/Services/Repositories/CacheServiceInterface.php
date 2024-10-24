<?php
namespace App\Services\Repositories;

interface CacheServiceInterface
{
    public function remember(string $key, int $ttl, callable $callback);
    public function forget(string $key): void;
    public function flush(): void;
}
