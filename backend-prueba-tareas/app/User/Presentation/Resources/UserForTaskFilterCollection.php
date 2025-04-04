<?php

namespace App\User\Presentation\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserForTaskFilterCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => $this->collection
        ];
    }
} 