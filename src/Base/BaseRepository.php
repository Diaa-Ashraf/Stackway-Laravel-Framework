<?php

namespace Stackway\Core\Base;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Stackway\Core\Contracts\RepositoryInterface;
use Stackway\Core\Support\CacheManager;

abstract class BaseRepository implements RepositoryInterface
{
    /**
     * The model instance.
     */
    protected Model $model;

    /**
     * Default columns to select (NEVER use select(*) on large tables).
     * Override in child repositories.
     */
    protected array $selectColumns = ['*'];

    /**
     * Default eager-load relations.
     * Override in child repositories.
     */
    protected array $with = [];

    /**
     * Cache prefix for this repository.
     * Override or leave null for auto-generation from model name.
     */
    protected ?string $cachePrefix = null;

    /**
     * Cache TTL in seconds.
     */
    protected int $cacheTtl;

    public function __construct()
    {
        $this->model = app($this->model());
        $this->cacheTtl = config('stackway.performance.cache_ttl', 3600);
    }

    /**
     * Return the fully qualified model class name.
     */
    abstract protected function model(): string;

    /**
     * Find a record by ID.
     */
    public function findById(int $id, array $select = []): ?Model
    {
        $columns = !empty($select) ? $select : $this->selectColumns;

        return $this->model->newQuery()
            ->select($columns)
            ->with($this->with)
            ->findOrFail($id);
    }

    /**
     * Get paginated results. ALWAYS paginate — never use all() or get() on large tables.
     */
    public function paginate(int $perPage = 0, array $select = []): LengthAwarePaginator
    {
        $perPage = $perPage ?: config('stackway.performance.pagination', 15);
        $columns = !empty($select) ? $select : $this->selectColumns;

        return $this->newQuery()
            ->select($columns)
            ->with($this->with)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Create a new record and clear cache.
     */
    public function create(array $data): Model
    {
        $record = $this->model->newQuery()->create($data);
        $this->clearCache();
        return $record;
    }

    /**
     * Update a record and clear cache.
     */
    public function update(int $id, array $data): Model
    {
        $record = $this->findById($id);
        $record->update($data);
        $this->clearCache();
        return $record->fresh();
    }

    /**
     * Delete a record and clear cache.
     */
    public function delete(int $id): bool
    {
        $record = $this->findById($id);
        $this->clearCache();
        return $record->delete();
    }

    /**
     * Clear all cache entries for this repository.
     */
    public function clearCache(): void
    {
        CacheManager::forgetByPrefix($this->getCachePrefix());
    }

    /**
     * Get a cached query result.
     */
    protected function remember(string $key, callable $callback, ?int $ttl = null): mixed
    {
        $fullKey = $this->getCachePrefix() . '_' . $key;
        return CacheManager::remember($fullKey, $ttl ?? $this->cacheTtl, $callback);
    }

    /**
     * Start a new query builder instance.
     */
    protected function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Get the cache prefix for this repository.
     */
    protected function getCachePrefix(): string
    {
        if ($this->cachePrefix) {
            return $this->cachePrefix;
        }

        return strtolower(class_basename($this->model));
    }
}
