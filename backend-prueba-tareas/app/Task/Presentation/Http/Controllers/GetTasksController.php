<?php

namespace App\Task\Presentation\Http\Controllers;

use App\Task\Application\Services\GetTasksService;
use App\Task\Application\Commands\GetTasksCommand;
use App\Task\Domain\Specifications\TaskByUsersSpecification;
use App\Task\Presentation\Resources\TaskCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class GetTasksController
{
    private GetTasksService $getTasksService;

    public function __construct(GetTasksService $getTasksService)
    {
        $this->getTasksService = $getTasksService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $userIds = $request->input('user_ids');
            
            $specification = new TaskByUsersSpecification(
                userIds: $userIds ? explode(',', $userIds) : null,
                includeUser: true
            );

            $command = new GetTasksCommand($specification);
            $tasks = $this->getTasksService->execute($command);
            
            return (new TaskCollection($tasks))->response();
        } catch (\Exception $e) {
            Log::error('Error getting tasks: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'message' => 'Error al obtener las tareas',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 