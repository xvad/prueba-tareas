<?php

namespace App\User\Application\Services;

use App\User\Application\Repositories\UserRepositoryInterface;
use App\User\Domain\Entities\User;

class GetUsersService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return array<User>
     */
    public function execute(): array
    {
        return $this->userRepository->all();
    }
} 