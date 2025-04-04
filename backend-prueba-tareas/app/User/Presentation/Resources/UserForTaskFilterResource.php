<?php

namespace App\User\Presentation\Resources;

use App\User\Domain\Entities\UserForTaskFilter;
use Illuminate\Http\Resources\Json\JsonResource;

class UserForTaskFilterResource extends JsonResource
{
    public function __construct(private UserForTaskFilter $user)
    {
        parent::__construct($user);
    }

    public function toArray($request): array
    {
        return [
            'id' => $this->user->getId(),
            'name' => $this->user->getName()
        ];
    }
} 