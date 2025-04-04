<?php

namespace App\Task\Infrastructure\Repositories;

use App\Task\Domain\Entities\Task as TaskEntity;
use App\Task\Domain\Repositories\TaskRepositoryInterface;
use App\Task\Infrastructure\Models\Task as TaskModel;
use App\Shared\Infrastructure\Repositories\BaseRepository;
use App\Task\Domain\Specifications\TaskSpecification;
use App\Task\Domain\Specifications\TaskByUsersSpecification;
use Illuminate\Database\Eloquent\Model;

class EloquentTaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function __construct(TaskModel $model)
    {
        parent::__construct($model);
    }

    public function findAllByUserId(int $userId): array
    {
        return $this->model->where('user_id', $userId)
            ->get()
            ->toArray();
    }

    public function getStats(int $userId): array
    {
        return $this->model->where('user_id', $userId)
            ->selectRaw('state, count(*) as count')
            ->groupBy('state')
            ->get()
            ->toArray();
    }

    public function allBySpecification(TaskSpecification $specification): array
    {
        $query = $this->model->query();

        if ($specification instanceof TaskByUsersSpecification) {
            if ($specification->getUserIds() !== null) {
                $query->whereIn('user_id', $specification->getUserIds());
            }

            if ($specification->shouldIncludeUser()) {
                $query->with('user:id,name,email');
            }
        }

        return $query->get()->map(function ($model) {
            $task = $this->toEntity($model);
            if ($model->relationLoaded('user')) {
                $task->setUserData([
                    'name' => $model->user->name,
                    'email' => $model->user->email
                ]);
            }
            return $task;
        })->toArray();
    }

    public function count(): int
    {
        return $this->model->count();
    }

    public function countByUserId(int $userId): int
    {
        return $this->model->where('user_id', $userId)->count();
    }

    protected function toEntity(Model $model): TaskEntity
    {
        return new TaskEntity(
            $model->title,
            $model->description,
            $model->state,
            $model->user_id,
            $model->id,
            $model->created_at,
            $model->updated_at
        );
    }

    protected function toArray($entity): array
    {
        return [
            'title' => $entity->getTitle(),
            'description' => $entity->getDescription(),
            'state' => $entity->getState(),
            'user_id' => $entity->getUserId()
        ];
    }

    protected function updateModel(Model $model, $entity): void
    {
        $model->title = $entity->getTitle();
        $model->description = $entity->getDescription();
        $model->state = $entity->getState();
        $model->user_id = $entity->getUserId();
    }
} 