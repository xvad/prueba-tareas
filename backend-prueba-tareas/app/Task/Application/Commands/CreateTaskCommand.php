<?php

namespace App\Task\Application\Commands;

class CreateTaskCommand
{
    public function __construct(
        private readonly string $title,
        private readonly string $description,
        private readonly string $state,
        private readonly int $userId
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
} 