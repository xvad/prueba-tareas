<?php

namespace App\Auth\Application\Services;

use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutService
{
    public function execute(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }
} 