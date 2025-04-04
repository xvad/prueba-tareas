<?php

namespace App\Auth\Presentation\Http\Controllers;

use App\Auth\Application\Services\GetAuthenticatedUserService;
use App\Auth\Presentation\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class MeController extends Controller
{
    private GetAuthenticatedUserService $getAuthenticatedUserService;

    public function __construct(GetAuthenticatedUserService $getAuthenticatedUserService)
    {
        $this->getAuthenticatedUserService = $getAuthenticatedUserService;
    }

    public function __invoke(): JsonResponse
    {
        $user = $this->getAuthenticatedUserService->execute();

        return response()->json([
            'data' => new UserResource($user)
        ], 200);
    }
} 