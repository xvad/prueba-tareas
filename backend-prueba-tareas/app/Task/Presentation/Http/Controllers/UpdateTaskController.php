<?php

namespace App\Task\Presentation\Http\Controllers;

use App\Task\Application\Commands\UpdateTaskCommand;
use App\Task\Application\Services\UpdateTaskService;
use App\Task\Presentation\Http\Requests\UpdateTaskRequest;
use App\Task\Presentation\Resources\TaskResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UpdateTaskController
{
    private UpdateTaskService $updateTaskService;

    public function __construct(UpdateTaskService $updateTaskService)
    {
        $this->updateTaskService = $updateTaskService;
    }

    public function __invoke(UpdateTaskRequest $request, int $id): JsonResponse
    {
        try {
            $command = new UpdateTaskCommand(
                id: $id,
                title: $request->input('title'),
                description: $request->input('description'),
                state: $request->input('state'),
                userId: Auth::id()
            );

            $task = $this->updateTaskService->execute($command);
            
            return (new TaskResource($task))->response();
        } catch (\Exception $e) {
            Log::error('Error updating task: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'task_id' => $id
            ]);

            return response()->json([
                'message' => 'Error updating task',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 