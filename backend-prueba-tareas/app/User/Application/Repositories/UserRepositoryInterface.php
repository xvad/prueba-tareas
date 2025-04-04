<?php

namespace App\User\Application\Repositories;

use App\User\Domain\Entities\UserForTaskFilter;
use App\Shared\Domain\Repositories\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Obtiene todos los usuarios que han creado al menos una tarea
     * @return array<UserForTaskFilter>
     */
    public function allWithTasks(): array;
} 