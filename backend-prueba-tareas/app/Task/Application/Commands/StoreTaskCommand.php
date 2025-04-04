<?php

namespace App\Task\Application\Commands;

use App\Task\Domain\Entities\Task;

class StoreTaskCommand
{
    private string $title;
    private ?string $description;
    private string $state;
    private int $userId;

    public function __construct(
        string $title,
        ?string $description,
        string $state,
        int $userId
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->state = $state;
        $this->userId = $userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
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