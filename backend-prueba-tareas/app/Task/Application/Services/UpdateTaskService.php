<?php

namespace App\Task\Application\Services;

use App\Task\Application\Commands\UpdateTaskCommand;
use App\Task\Domain\Entities\Task;
use App\Task\Domain\Repositories\TaskRepositoryInterface;

class UpdateTaskService
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function execute(UpdateTaskCommand $command): Task
    {

        $task = new Task(
            title: $command->getTitle(),
            description: $command->getDescription() ?? '',
            state: $command->getState(),
            userId: $command->getUserId()
        );
        return $this->taskRepository->update($command->getId(), $task);
    }
} 