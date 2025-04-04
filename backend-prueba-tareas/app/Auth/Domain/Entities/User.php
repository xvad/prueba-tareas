<?php

namespace App\Auth\Domain\Entities;

use App\Auth\Domain\ValueObjects\Email;
use App\Auth\Domain\ValueObjects\Password;

class User
{
    private ?int $id;
    private string $name;
    private Email $email;
    private Password $password;
    private bool $status;
    private ?string $lastLoginAt;

    public function __construct(
        string $name,
        Email $email,
        Password $password,
        bool $status = true,
        ?string $lastLoginAt = null,
        ?int $id = null
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->status = $status;
        $this->lastLoginAt = $lastLoginAt;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function isActive(): bool
    {
        return $this->status;
    }

    public function getLastLoginAt(): ?string
    {
        return $this->lastLoginAt;
    }

    public function updateLastLogin(): void
    {
        $this->lastLoginAt = now()->toDateTimeString();
    }
} 