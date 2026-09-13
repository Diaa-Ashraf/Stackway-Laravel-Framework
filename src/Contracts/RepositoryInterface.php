<?php

namespace Stackway\Core\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    /**
     * Find a record by its primary key.
     *
     * @param int $id
     * @param array<string> $select Columns to select
     * @return Model|null
     */
    public function findById(int $id, array $select = []): ?Model;

    /**
     * Get paginated results.
     *
     * @param int $perPage Items per page (0 = use config default)
     * @param array<string> $select Columns to select
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 0, array $select = []): LengthAwarePaginator;

    /**
     * Create a new record.
     *
     * @param array<string, mixed> $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * Update an existing record.
     *
     * @param int $id
     * @param array<string, mixed> $data
     * @return Model
     */
    public function update(int $id, array $data): Model;

    /**
     * Delete a record.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Clear all cached data for this repository.
     */
    public function clearCache(): void;
}
