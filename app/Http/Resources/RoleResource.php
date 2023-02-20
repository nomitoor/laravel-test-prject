<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
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
