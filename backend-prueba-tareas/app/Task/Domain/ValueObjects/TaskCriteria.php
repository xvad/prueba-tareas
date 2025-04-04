<?php

namespace App\Task\Domain\ValueObjects;

class TaskCriteria
{
    private ?array $userIds;
    private bool $includeUser;

    public function __construct(?array $userIds = null, bool $includeUser = false)
    {
        $this->userIds = $userIds;
        $this->includeUser = $includeUser;
    }

    public function getUserIds(): ?array
    {
        return $this->userIds;
    }

    public function shouldIncludeUser(): bool
    {
        return $this->includeUser;
    }
} 