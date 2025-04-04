<?php

namespace App\Task\Application\Services;

use App\Task\Domain\Repositories\TaskRepositoryInterface;
use App\Task\Application\Commands\DeleteTaskCommand;

class DeleteTaskService
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function execute(DeleteTaskCommand $command): void
    {
        $this->taskRepository->delete($command->getId());
    }
} 