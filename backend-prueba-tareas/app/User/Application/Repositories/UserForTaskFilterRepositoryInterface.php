<?php

namespace App\User\Application\Repositories;

use App\User\Domain\Entities\UserForTaskFilter;

interface UserForTaskFilterRepositoryInterface
{
    /**
     * @return array<UserForTaskFilter>
     */
    public function all(): array;
} 