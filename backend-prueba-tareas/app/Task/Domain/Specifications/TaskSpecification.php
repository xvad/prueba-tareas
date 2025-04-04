<?php

namespace App\Task\Domain\Specifications;

interface TaskSpecification
{
    public function isSatisfiedBy($task): bool;
} 