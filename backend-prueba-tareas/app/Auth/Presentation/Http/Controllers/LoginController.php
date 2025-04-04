<?php

namespace App\Auth\Presentation\Http\Controllers;

use App\Auth\Application\Commands\LoginCommand;
use App\Auth\Application\Services\AuthService;
use App\Auth\Application\Services\LoginService;
use App\Auth\Presentation\Http\Requests\LoginRequest;
use App\Auth\Presentation\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class LoginController extends Controller
{
    private LoginService $loginService;
    private AuthService $authService;

    public function __construct(LoginService $loginService, AuthService $authService)
    {
        $this->loginService = $loginService;
        $this->authService = $authService;
    }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        $command = new LoginCommand(
            $request->input('email'),
            $request->input('password'),
            $request->boolean('remember_me', false)
        );

        $user = $this->loginService->execute($command);

        if (!$user) {
            return response()->json([
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        $token = $this->authService->generateToken($user, $command->getRememberMe());
        $expiresIn = $this->authService->getTokenExpiration();

        return response()->json([
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $expiresIn,
                'user' => new UserResource($user)
            ]
        ], 200);
    }
} 