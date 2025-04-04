<?php

namespace App\Shared\Domain\Repositories;

/**
 * @template TEntity
 */
interface BaseRepositoryInterface
{
    /**
     * Find a record by its ID
     *
     * @param int $id
     * @return TEntity|null
     */
    public function findById(int $id);

    /**
     * Get all records
     *
     * @return TEntity[]
     */
    public function all(): array;

    /**
     * Create a new record
     *
     * @param TEntity $entity
     * @return TEntity
     */
    public function save($entity);

    /**
     * Update a record
     *
     * @param int $id
     * @param TEntity $entity
     * @return TEntity|null
     */
    public function update(int $id, $entity);

    /**
     * Delete a record
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Find records by a specific field
     *
     * @param string $field
     * @param mixed $value
     * @return TEntity|null
     */
    public function findBy(string $field, $value);

    /**
     * Get paginated records
     *
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = 15);

} 