<?php

namespace App\Task\Presentation\Http\Controllers;

use App\Task\Application\Services\DeleteTaskService;
use App\Task\Application\Commands\DeleteTaskCommand;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class DeleteTaskController
{
    private DeleteTaskService $deleteTaskService;

    public function __construct(DeleteTaskService $deleteTaskService)
    {
        $this->deleteTaskService = $deleteTaskService;
    }

    public function __invoke(int $id): JsonResponse
    {
        try {
            $command = new DeleteTaskCommand($id);
            $this->deleteTaskService->execute($command);
            return response()->json(['message' => 'Task deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting task: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'task_id' => $id
            ]);

            return response()->json([
                'message' => 'Error deleting task',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 