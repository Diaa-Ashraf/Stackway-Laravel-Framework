<?php

namespace Stackway\Core\Support;

use Illuminate\Support\Facades\Cache;

class CacheManager
{
    /**
     * Cache a value with a key and TTL (optionally with prefix registry tracking).
     */
    public static function remember(string $key, int $ttl, callable $callback, ?string $prefix = null): mixed
    {
        if ($prefix !== null) {
            $fullKey = "{$prefix}_{$key}";
            static::registerKey($prefix, $fullKey);
            return Cache::remember($fullKey, $ttl, $callback);
        }

        return Cache::remember($key, $ttl, $callback);
    }

    /**
     * Cache a value forever.
     */
    public static function forever(string $key, callable $callback): mixed
    {
        return Cache::rememberForever($key, $callback);
    }

    /**
     * Remove a cached item.
     */
    public static function forget(string $key): bool
    {
        return Cache::forget($key);
    }

    /**
     * Remove all cached items with a given prefix.
     * Uses a registry approach to track cached keys by prefix.
     */
    public static function forgetByPrefix(string $prefix): void
    {
        $registryKey = "cache_registry_{$prefix}";
        $keys = Cache::get($registryKey, []);

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        Cache::forget($registryKey);
    }

    /**
     * Register a key in the prefix registry (call this when caching with remember).
     */
    public static function registerKey(string $prefix, string $key): void
    {
        $registryKey = "cache_registry_{$prefix}";
        $keys = Cache::get($registryKey, []);

        if (!in_array($key, $keys)) {
            $keys[] = $key;
            Cache::forever($registryKey, $keys);
        }
    }

    /**
     * Remember with automatic key registration for prefix-based invalidation.
     */
    public static function rememberWithPrefix(string $prefix, string $key, int $ttl, callable $callback): mixed
    {
        $fullKey = "{$prefix}_{$key}";
        static::registerKey($prefix, $fullKey);

        return Cache::remember($fullKey, $ttl, $callback);
    }

    /**
     * Check if a key exists in cache.
     */
    public static function has(string $key): bool
    {
        return Cache::has($key);
    }

    /**
     * Get a cached value.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::get($key, $default);
    }

    /**
     * Set a cached value directly.
     */
    public static function put(string $key, mixed $value, int $ttl): void
    {
        Cache::put($key, $value, $ttl);
    }

    /**
     * Flush the entire cache.
     */
    public static function flush(): bool
    {
        return Cache::flush();
    }
}
