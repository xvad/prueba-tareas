<?php

namespace App\User\Infrastructure\Repositories;

use App\Auth\Infrastructure\Models\User as UserModel;
use App\User\Application\Repositories\UserRepositoryInterface;
use App\User\Domain\Entities\UserForTaskFilter;
use App\Shared\Infrastructure\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class EloquentUserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(UserModel $model)
    {
        parent::__construct($model);
    }

    public function allWithTasks(): array
    {
        $users = $this->model
            ->select('users.id', 'users.name')
            ->join('tasks', 'users.id', '=', 'tasks.user_id')
            ->distinct()
            ->get();

        return $this->mapToDomainEntities($users);
    }

    /**
     * @param Collection<UserModel> $users
     * @return array<UserForTaskFilter>
     */
    private function mapToDomainEntities(Collection $users): array
    {
        return $users->map(function (UserModel $user) {
            return new UserForTaskFilter(
                id: $user->id,
                name: $user->name
            );
        })->all();
    }

    protected function toEntity(Model $model): UserForTaskFilter
    {
        return new UserForTaskFilter(
            id: $model->id,
            name: $model->name
        );
    }

    protected function toArray($entity): array
    {
        return [
            'id' => $entity->getId(),
            'name' => $entity->getName()
        ];
    }

    protected function updateModel(Model $model, $entity): void
    {
        $model->id = $entity->getId();
        $model->name = $entity->getName();
    }
} 