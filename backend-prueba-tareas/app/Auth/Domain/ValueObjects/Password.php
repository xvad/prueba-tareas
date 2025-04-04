<?php

namespace App\Auth\Domain\ValueObjects;

use InvalidArgumentException;
use Illuminate\Support\Facades\Hash;

class Password
{
    private string $value;
    private bool $isHashed;

    public function __construct(string $password, bool $isHashed = false)
    {
        if (!$isHashed) {
            $this->validate($password);
        }
        $this->value = $password;
        $this->isHashed = $isHashed;
    }

    private function validate(string $password): void
    {
        if (strlen($password) < 8) {
            throw new InvalidArgumentException('Password must be at least 8 characters long');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getHashedValue(): string
    {
        if ($this->isHashed) {
            return $this->value;
        }
        return Hash::make($this->value);
    }

    public function verify(string $plainPassword): bool
    {
        if ($this->isHashed) {
            return Hash::check($plainPassword, $this->value);
        }
        return $this->value === $plainPassword;
    }
} 