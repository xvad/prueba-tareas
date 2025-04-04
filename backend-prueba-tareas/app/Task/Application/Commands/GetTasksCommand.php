<?php

namespace App\Task\Application\Commands;

use App\Task\Domain\Specifications\TaskSpecification;

class GetTasksCommand
{
    private TaskSpecification $specification;

    public function __construct(TaskSpecification $specification)
    {
        $this->specification = $specification;
    }

    public function getSpecification(): TaskSpecification
    {
        return $this->specification;
    }
} 