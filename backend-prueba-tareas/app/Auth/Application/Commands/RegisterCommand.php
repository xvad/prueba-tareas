<?php

namespace App\Auth\Application\Commands;

use App\Auth\Domain\ValueObjects\Email;
use App\Auth\Domain\ValueObjects\Password;

class RegisterCommand
{
    private string $name;
    private Email $email;
    private Password $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = new Email($email);
        $this->password = new Password($password);
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
} 