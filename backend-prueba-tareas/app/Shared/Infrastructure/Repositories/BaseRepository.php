<?php

namespace App\Shared\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * @template TEntity
 * @template TModel of Model
 */
abstract class BaseRepository
{
    /**
     * @var TModel
     */
    protected Model $model;

    /**
     * @param TModel $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Find a record by its ID
     *
     * @param int $id
     * @return TEntity|null
     */
    public function findById(int $id)
    {
        $model = $this->model->find($id);
        return $model ? $this->toEntity($model) : null;
    }

    /**
     * Get all records
     *
     * @return TEntity[]
     */
    public function all(): array
    {
        return $this->model->all()->toArray();
    }

    /**
     * save a new record
     *
     * @param TEntity $entity
     * @return TEntity
     */
    public function save($entity)
    {
        $model = new $this->model;
        $this->updateModel($model, $entity);
        $model->save();
        return $this->toEntity($model);
    }

    /**
     * Update a record
     *
     * @param int $id
     * @param TEntity $entity
     * @return TEntity|null
     */
    public function update(int $id, $entity)
    {
        $model = $this->model->find($id);
        if ($model) {
            $this->updateModel($model, $entity);
            $model->save();
            return $this->toEntity($model);
        }
        return null;
    }

    /**
     * Delete a record
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $model = $this->model->find($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }

    /**
     * Find records by a specific field
     *
     * @param string $field
     * @param mixed $value
     * @return TEntity|null
     */
    public function findBy(string $field, $value)
    {
        $model = $this->model->where($field, $value)->first();
        return $model ? $this->toEntity($model) : null;
    }

    /**
     * Get paginated records
     *
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = 15)
    {
        return $this->model->paginate($perPage)->through(fn($model) => $this->toEntity($model));
    }

    /**
     * Convert a model to an entity
     *
     * @param TModel $model
     * @return TEntity
     */
    abstract protected function toEntity(Model $model);

    /**
     * Update a model with entity data
     *
     * @param TModel $model
     * @param TEntity $entity
     * @return void
     */
    abstract protected function updateModel(Model $model, $entity): void;
} 