<?php

namespace App\Auth\Infrastructure\Repositories;

use App\Auth\Domain\Entities\User;
use App\Auth\Domain\Repositories\AuthRepositoryInterface;
use App\Auth\Domain\ValueObjects\Email;
use App\Auth\Domain\ValueObjects\Password;
use App\Auth\Infrastructure\Models\User as UserModel;
use Illuminate\Database\Eloquent\Model;
use App\Shared\Infrastructure\Repositories\BaseRepository;
/**
 * @extends BaseRepository<User, UserModel>
 * @implements AuthRepositoryInterface
 */
class EloquentAuthRepository extends BaseRepository implements AuthRepositoryInterface
{
    /**
     * @param UserModel $model
     */
    public function __construct(UserModel $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function findByEmail(string $email)
    {
        $model = $this->model->where('email', $email)->first();
        return $model ? $this->toEntity($model) : null;
    }

    /**
     * @inheritDoc
     */
    public function updateLastLogin(int $userId): void
    {
        $user = $this->model->find($userId);
        if ($user) {
            $user->last_login_at = now();
            $user->save();
        }
    }

    /**
     * @inheritDoc
     */
    protected function toEntity(Model $model): User
    {
        return new User(
            id: $model->id,
            name: $model->name,
            email: new Email($model->email),
            password: new Password($model->password, true),
            lastLoginAt: $model->last_login_at
        );
    }

    /**
     * @inheritDoc
     */
    protected function toArray($entity): array
    {
        return [
            'name' => $entity->getName(),
            'email' => $entity->getEmail()->getValue(),
            'password' => $entity->getPassword()->getHashedValue(),
            'last_login_at' => $entity->getLastLoginAt()
        ];
    }

    /**
     * @inheritDoc
     */
    protected function updateModel(Model $model, $entity): void
    {
        $model->name = $entity->getName();
        $model->email = $entity->getEmail()->getValue();
        $model->password = $entity->getPassword()->getHashedValue();
        $model->last_login_at = $entity->getLastLoginAt();
    }
} 