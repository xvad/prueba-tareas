<?php

namespace App\Auth\Application\Services;

use App\Auth\Application\Commands\LoginCommand;
use App\Auth\Domain\Repositories\AuthRepositoryInterface;
use App\Auth\Domain\Entities\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Auth\Domain\ValueObjects\Email;
use App\Auth\Domain\ValueObjects\Password;

class LoginService
{
    private AuthRepositoryInterface $userRepository;

    public function __construct(AuthRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(LoginCommand $command): ?User
    {
        $user = $this->userRepository->findByEmail($command->getEmail());

        if (!$user || !$user->getPassword()->verify($command->getPassword())) {
            return null;
        }

        $this->userRepository->updateLastLogin($user->getId());

        return $user;
    }
} 