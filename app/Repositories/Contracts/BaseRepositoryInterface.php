<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    /**
     * Get model by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model;
    
    /**
     * Find model by UUID
     *
     * @param string $uuid
     * @return Model|null
     */
    public function findByUuid(string $uuid): ?Model;
    
    /**
     * Get paginated results
     *
     * @param int $perPage
     * @param array $columns
     * @param array $relations
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = [], array $filters = []): LengthAwarePaginator;
    
    /**
     * Create a new model
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;
    
    /**
     * Update existing model
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model;
    
    /**
     * Delete model by ID
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
    
    /**
     * Force delete a model (permanent)
     *
     * @param int $id
     * @return bool
     */
    public function forceDelete(int $id): bool;
    
    /**
     * Restore a soft-deleted model
     *
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool;
    
    /**
     * Process data in chunks by ID
     *
     * @param int $count
     * @param callable $callback
     * @return bool
     */
    public function chunkById(int $count, callable $callback): bool;
}
