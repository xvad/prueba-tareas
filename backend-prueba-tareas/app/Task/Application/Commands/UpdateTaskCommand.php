<?php

namespace App\Task\Application\Commands;

class UpdateTaskCommand
{
    private int $id;
    private ?string $title;
    private ?string $description;
    private ?string $state;
    private int $userId;

    public function __construct(
        int $id,
        ?string $title,
        ?string $description,
        ?string $state,
        int $userId
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->state = $state;
        $this->userId = $userId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
} 