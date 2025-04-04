<?php

namespace App\User\Application\Services;

use App\User\Application\Repositories\UserRepositoryInterface;
use App\User\Domain\Entities\UserForTaskFilter;

class GetUsersForTaskFilterService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return array<UserForTaskFilter>
     */
    public function execute(): array
    {
        return $this->userRepository->allWithTasks();
    }
} 