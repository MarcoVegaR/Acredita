<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseServiceInterface
{
    /**
     * Find model by ID
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
     * Create a new record
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;
    
    /**
     * Update existing record
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model;
    
    /**
     * Delete record by ID
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
    
    /**
     * Force delete a record (permanent)
     *
     * @param int $id
     * @return bool
     */
    public function forceDelete(int $id): bool;
    
    /**
     * Restore a soft-deleted record
     *
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool;
}
