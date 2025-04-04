<?php

namespace App\Auth\Application\Services;

use App\Auth\Domain\Entities\User;
use App\Auth\Infrastructure\Models\User as UserModel;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;

class AuthService
{
    private JWT $jwt;

    public function __construct(JWT $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * Generate a JWT token for a user
     *
     * @param User $user
     * @param bool $rememberMe
     * @return string
     */
    public function generateToken(User $user, bool $rememberMe = false): string
    {
        // Convertir la entidad de dominio a un modelo de Eloquent
        $userModel = UserModel::find($user->getId());
        
        if (!$userModel) {
            throw new \Exception('User model not found');
        }
        
        // Si se selecciona "recordar sesión", configuramos un tiempo de expiración más largo
        if ($rememberMe) {
            // Configurar el tiempo de expiración para 30 días
            config(['jwt.ttl' => 60 * 24 * 30]);
        } else {
            // Configurar el tiempo de expiración para 1 hora (valor predeterminado)
            config(['jwt.ttl' => 60]);
        }
        
        return JWTAuth::fromUser($userModel);
    }
    
    /**
     * Get the token expiration time in seconds
     *
     * @return int
     */
    public function getTokenExpiration(): int
    {
        return config('jwt.ttl', 60) * 60;
    }
} 