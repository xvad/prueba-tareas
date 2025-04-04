<?php

namespace App\Task\Presentation\Resources;

use App\Task\Domain\Entities\Task;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function __construct(private Task $task)
    {
        parent::__construct($task);
    }

    public function toArray($request): array
    {
        $data = [
            'id' => $this->task->getId(),
            'title' => $this->task->getTitle(),
            'description' => $this->task->getDescription(),
            'state' => $this->task->getState(),
            'user_id' => $this->task->getUserId(),
            'created_at' => $this->task->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $this->task->getUpdatedAt()->format('Y-m-d H:i:s')
        ];

        if ($userData = $this->task->getUserData()) {
            $data['user'] = $userData;
        }

        return $data;
    }
} 