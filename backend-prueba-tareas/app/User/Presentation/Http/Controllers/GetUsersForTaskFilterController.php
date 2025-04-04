<?php

namespace App\User\Presentation\Http\Controllers;

use App\User\Application\Services\GetUsersForTaskFilterService;
use App\User\Presentation\Resources\UserForTaskFilterCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class GetUsersForTaskFilterController
{
    private GetUsersForTaskFilterService $getUsersService;

    public function __construct(GetUsersForTaskFilterService $getUsersService)
    {
        $this->getUsersService = $getUsersService;
    }

    public function __invoke(): JsonResponse
    {
        try {
            $users = $this->getUsersService->execute();
            return (new UserForTaskFilterCollection($users))->response();
        } catch (\Exception $e) {
            Log::error('Error getting users for task filter: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Error al obtener los usuarios para el filtro de tareas',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 