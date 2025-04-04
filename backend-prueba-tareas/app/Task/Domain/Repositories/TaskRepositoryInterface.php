<?php

namespace App\Task\Domain\Repositories;

use App\Task\Domain\Entities\Task;
use App\Task\Domain\Specifications\TaskSpecification;

interface TaskRepositoryInterface
{
    public function findAllByUserId(int $userId): array;
    public function getStats(int $userId): array;
    public function allBySpecification(TaskSpecification $specification): array;
    public function count(): int;
    public function countByUserId(int $userId): int;
} 