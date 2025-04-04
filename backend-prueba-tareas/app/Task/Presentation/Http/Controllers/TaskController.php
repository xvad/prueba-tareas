<?php

namespace App\Task\Presentation\Http\Controllers;

use App\Task\Application\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(): JsonResponse
    {
        $tasks = $this->taskService->getTasks(Auth::id());
        return response()->json($tasks);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'state' => 'required|string'
        ]);

        $this->taskService->createTask(
            $validated['title'],
            $validated['description'],
            $validated['state'],
            Auth::id()
        );

        return response()->json(['message' => 'Task created successfully'], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'state' => 'required|string'
        ]);

        $this->taskService->updateTask(
            $id,
            $validated['title'],
            $validated['description'],
            $validated['state']
        );

        return response()->json(['message' => 'Task updated successfully']);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->taskService->deleteTask($id);
        return response()->json(['message' => 'Task deleted successfully']);
    }

    public function stats(): JsonResponse
    {
        $stats = $this->taskService->getStats(Auth::id());
        return response()->json($stats);
    }
} 