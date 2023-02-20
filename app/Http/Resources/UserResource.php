<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
        ];
    }

    /**
     * > The `with()` function is used to add additional data to the response
     * 
     * @param request The incoming HTTP request.
     * 
     * @return The version of the API.
     */
    public function with($request)
    {
        return [
            'version' => '1.0',
        ];
    }
}
