<?php

namespace App\Task\Domain\Specifications;

use App\Task\Domain\Entities\Task;

class TaskByUsersSpecification implements TaskSpecification
{
    private ?array $userIds;
    private bool $includeUser;

    public function __construct(?array $userIds = null, bool $includeUser = false)
    {
        $this->userIds = $userIds;
        $this->includeUser = $includeUser;
    }

    public function isSatisfiedBy($task): bool
    {
        if ($this->userIds === null) {
            return true;
        }
        return in_array($task->getUserId(), $this->userIds);
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