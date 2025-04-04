<?php

namespace App\Task\Presentation\Http\Controllers;

use App\Task\Application\Services\GetTaskStatsService;
use App\Task\Application\Commands\GetTaskStatsCommand;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GetTaskStatsController
{
    private GetTaskStatsService $getTaskStatsService;

    public function __construct(GetTaskStatsService $getTaskStatsService)
    {
        $this->getTaskStatsService = $getTaskStatsService;
    }

    public function __invoke(): JsonResponse
    {
        try {
            $command = new GetTaskStatsCommand();
            $stats = $this->getTaskStatsService->execute($command);
            
            return response()->json(['data' => $stats]);
        } catch (\Exception $e) {
            Log::error('Error getting task stats: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'message' => 'Error getting task stats',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 