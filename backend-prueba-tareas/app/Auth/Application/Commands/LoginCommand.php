<?php

namespace App\Auth\Application\Commands;

class LoginCommand
{
    private string $email;
    private string $password;
    private bool $rememberMe;

    public function __construct(string $email, string $password, bool $rememberMe = false)
    {
        $this->email = $email;
        $this->password = $password;
        $this->rememberMe = $rememberMe;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRememberMe(): bool
    {
        return $this->rememberMe;
    }
} 