<?php

namespace App\Auth\Presentation\Resources;

use App\Auth\Domain\Entities\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function __construct(private User $user)
    {
        parent::__construct($user);
    }

    public function toArray($request): array
    {
        return [
            'id' => $this->user->getId(),
            'name' => $this->user->getName(),
            'email' => $this->user->getEmail()->getValue(),
            'status' => $this->user->isActive(),
            'last_login_at' => $this->user->getLastLoginAt(),
        ];
    }
} 