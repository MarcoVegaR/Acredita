<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\BaseRepositoryInterface;
use App\Services\Contracts\BaseServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseService implements BaseServiceInterface
{
    /**
     * @var BaseRepositoryInterface
     */
    protected BaseRepositoryInterface $repository;
    
    /**
     * BaseService constructor
     *
     * @param BaseRepositoryInterface $repository
     */
    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * Find model by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->repository->find($id);
    }
    
    /**
     * Find model by UUID
     *
     * @param string $uuid
     * @return Model|null
     */
    public function findByUuid(string $uuid): ?Model
    {
        return $this->repository->findByUuid($uuid);
    }
    
    /**
     * Get paginated results
     *
     * @param int $perPage
     * @param array $columns
     * @param array $relations
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = [], array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage, $columns, $relations, $filters);
    }
    
    /**
     * Create a new record
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }
    
    /**
     * Update existing record
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model
    {
        return $this->repository->update($id, $data);
    }
    
    /**
     * Delete record by ID
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
    
    /**
     * Force delete a record (permanent)
     *
     * @param int $id
     * @return bool
     */
    public function forceDelete(int $id): bool
    {
        return $this->repository->forceDelete($id);
    }
    
    /**
     * Restore a soft-deleted record
     *
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        return $this->repository->restore($id);
    }
}
