<?php

namespace App\Auth\Application\Services;

use App\Auth\Application\Commands\RegisterCommand;
use App\Auth\Domain\Repositories\AuthRepositoryInterface;
use App\Auth\Domain\Entities\User;
use App\Auth\Domain\ValueObjects\Email;
use App\Auth\Domain\ValueObjects\Password;

class RegisterService
{
    private AuthRepositoryInterface $userRepository;

    public function __construct(AuthRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(RegisterCommand $command): User
    {
        $existingUser = $this->userRepository->findByEmail($command->getEmail());
        
        if ($existingUser) {
            throw new \Exception('User already exists');
        }

        $user = new User(
            $command->getName(),
            $command->getEmail(),
            $command->getPassword()
        );

        $this->userRepository->save($user);

        return $user;
    }
} 