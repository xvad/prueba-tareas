<?php

namespace App\Auth\Domain\Repositories;

use App\Auth\Domain\Entities\User;
use App\Auth\Domain\ValueObjects\Email;

/**
 * @extends BaseRepositoryInterface<User>
 */
interface AuthRepositoryInterface
{
    /**
     * Find a user by email
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email);

    /**
     * Update the last login timestamp for a user
     *
     * @param int $userId
     * @return void
     */
    public function updateLastLogin(int $userId): void;
} 