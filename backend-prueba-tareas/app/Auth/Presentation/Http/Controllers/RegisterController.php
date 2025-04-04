<?php

namespace App\Auth\Presentation\Http\Controllers;

use App\Auth\Application\Commands\RegisterCommand;
use App\Auth\Application\Services\RegisterService;
use App\Auth\Presentation\Http\Requests\RegisterRequest;
use App\Auth\Presentation\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class RegisterController extends Controller
{
    private RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $command = new RegisterCommand(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        $user = $this->registerService->execute($command);

        return response()->json([
            'data' => [
                'user' => new UserResource($user)
            ]
        ], 201);
    }
} 