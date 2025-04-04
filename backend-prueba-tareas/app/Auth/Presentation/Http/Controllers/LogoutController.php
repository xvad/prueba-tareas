<?php

namespace App\Auth\Presentation\Http\Controllers;

use App\Auth\Application\Services\LogoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class LogoutController extends Controller
{
    private LogoutService $logoutService;

    public function __construct(LogoutService $logoutService)
    {
        $this->logoutService = $logoutService;
    }

    public function __invoke(): JsonResponse
    {
        $this->logoutService->execute();

        return response()->json(['message' => 'Successfully logged out']);
    }
} 