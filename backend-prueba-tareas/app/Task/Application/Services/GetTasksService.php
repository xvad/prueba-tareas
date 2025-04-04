<?php

namespace App\Task\Application\Services;

use App\Task\Domain\Entities\Task;
use App\Task\Domain\Repositories\TaskRepositoryInterface;
use App\Task\Application\Commands\GetTasksCommand;

class GetTasksService
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function execute(GetTasksCommand $command): array
    {
        return $this->taskRepository->allBySpecification($command->getSpecification());
    }
} 