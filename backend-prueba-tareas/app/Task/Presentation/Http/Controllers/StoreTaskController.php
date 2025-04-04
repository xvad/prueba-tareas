<?php

namespace App\Task\Presentation\Http\Controllers;

use App\Task\Application\Commands\StoreTaskCommand;
use App\Task\Application\Services\StoreTaskService;
use App\Task\Presentation\Http\Requests\StoreTaskRequest;
use App\Task\Presentation\Resources\TaskResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StoreTaskController
{
    private StoreTaskService $storeTaskService;

    public function __construct(StoreTaskService $storeTaskService)
    {
        $this->storeTaskService = $storeTaskService;
    }

    public function __invoke(StoreTaskRequest $request): JsonResponse
    {
        try {
            $command = new StoreTaskCommand(
                title: $request->input('title'),
                description: $request->input('description'),
                state: $request->input('state'),
                userId: Auth::id()
            );

            $task = $this->storeTaskService->execute($command);
            
            return (new TaskResource($task))->response()->setStatusCode(201);
        } catch (\Exception $e) {
            Log::error('Error creating task: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'message' => 'Error creating task',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 