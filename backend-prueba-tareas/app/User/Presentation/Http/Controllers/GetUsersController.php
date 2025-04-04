<?php

namespace App\User\Presentation\Http\Controllers;

use App\User\Application\Services\GetUsersService;
use App\User\Presentation\Resources\UserCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class GetUsersController
{
    private GetUsersService $getUsersService;

    public function __construct(GetUsersService $getUsersService)
    {
        $this->getUsersService = $getUsersService;
    }

    public function __invoke(): JsonResponse
    {
        try {
            $users = $this->getUsersService->execute();
            return (new UserCollection($users))->response();
        } catch (\Exception $e) {
            Log::error('Error getting users: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Error al obtener los usuarios',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 