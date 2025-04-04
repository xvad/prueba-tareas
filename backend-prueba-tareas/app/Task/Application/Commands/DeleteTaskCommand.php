<?php

namespace App\Task\Application\Commands;

class DeleteTaskCommand
{
    public function __construct(
        private readonly int $id
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
} 