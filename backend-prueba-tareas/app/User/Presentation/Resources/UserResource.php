<?php

namespace App\User\Presentation\Resources;

use App\User\Domain\Entities\User;
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
            'last_name' => $this->user->getLastName(),
            'email' => $this->user->getEmail(),
            'created_at' => $this->user->getCreatedAt()->format('Y-m-d H:i:s'),
            'updated_at' => $this->user->getUpdatedAt()->format('Y-m-d H:i:s')
        ];
    }
} 