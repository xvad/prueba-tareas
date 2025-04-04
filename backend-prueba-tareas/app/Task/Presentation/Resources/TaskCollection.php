<?php

namespace App\Task\Presentation\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => $this->collection
        ];
    }
} 