<?php

namespace App\Task\Domain\Entities;

class Task
{
    private int $id;
    private string $title;
    private ?string $description;
    private string $state;
    private int $userId;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;
    private ?array $userData = null;

    public function __construct(
        string $title,
        ?string $description,
        string $state,
        int $userId,
        ?int $id = null,
        ?\DateTime $createdAt = null,
        ?\DateTime $updatedAt = null
    ) {
        $this->id = $id ?? 0;
        $this->title = $title;
        $this->description = $description;
        $this->state = $state;
        $this->userId = $userId;
        $this->createdAt = $createdAt ?? new \DateTime();
        $this->updatedAt = $updatedAt ?? new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function getUserData(): ?array
    {
        return $this->userData;
    }

    public function setUserData(?array $userData): void
    {
        $this->userData = $userData;
    }

    public function update(string $title, string $description, string $state): void
    {
        $this->title = $title;
        $this->description = $description;
        $this->state = $state;
        $this->updatedAt = new \DateTime();
    }
} 