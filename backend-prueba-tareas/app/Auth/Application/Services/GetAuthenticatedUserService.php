<?php

namespace App\Auth\Application\Services;

use App\Auth\Domain\Repositories\AuthRepositoryInterface;
use App\Auth\Domain\Entities\User;
use Illuminate\Support\Facades\Auth;

class GetAuthenticatedUserService
{
    private AuthRepositoryInterface $userRepository;

    public function __construct(AuthRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(): User
    {
        $userId = Auth::id();
        $user = $this->userRepository->findById($userId);

        if (!$user) {
            throw new \Exception('User not found');
        }

        return $user;
    }
} 