<?php

namespace App\Task\Application\Services;

use App\Task\Application\Commands\GetTaskStatsCommand;
use App\Task\Domain\Repositories\TaskRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GetTaskStatsService
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository
    ) {}

    public function execute(GetTaskStatsCommand $command): array
    {
        return [
            'total_tasks' => $this->taskRepository->count(),
            'user_tasks' => $this->taskRepository->countByUserId(Auth::id())
        ];
    }
} 