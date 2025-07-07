<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get model by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }
    
    /**
     * Find model by UUID
     *
     * @param string $uuid
     * @return Model|null
     */
    public function findByUuid(string $uuid): ?Model
    {
        return $this->model->where('uuid', $uuid)->first();
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
        $query = $this->model->select($columns);
        
        if (!empty($relations)) {
            $query = $query->with($relations);
        }
        
        if (!empty($filters)) {
            $query = $this->applyFilters($query, $filters);
        }
        
        return $query->paginate($perPage);
    }
    
    /**
     * Create a new model
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }
    
    /**
     * Update existing model
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model
    {
        $model = $this->find($id);
        $model->update($data);
        return $model->fresh();
    }
    
    /**
     * Delete model by ID
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }
    
    /**
     * Force delete a model (permanent)
     *
     * @param int $id
     * @return bool
     */
    public function forceDelete(int $id): bool
    {
        if (method_exists($this->model, 'forceDelete')) {
            return $this->find($id)->forceDelete();
        }
        
        return $this->delete($id);
    }
    
    /**
     * Restore a soft-deleted model
     *
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        if (method_exists($this->model, 'restore')) {
            return $this->model->withTrashed()->find($id)->restore();
        }
        
        return false;
    }
    
    /**
     * Process data in chunks by ID
     *
     * @param int $count
     * @param callable $callback
     * @return bool
     */
    public function chunkById(int $count, callable $callback): bool
    {
        return $this->model->chunkById($count, $callback);
    }
    
    /**
     * Apply filters to query
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    protected function applyFilters(Builder $query, array $filters): Builder
    {
        foreach ($filters as $field => $value) {
            if (is_array($value)) {
                if (isset($value['operator']) && isset($value['value'])) {
                    $query->where($field, $value['operator'], $value['value']);
                } elseif (count($value) > 0) {
                    $query->whereIn($field, $value);
                }
            } else {
                $query->where($field, $value);
            }
        }
        
        return $query;
    }
}
