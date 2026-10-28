<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $currentUserId = $request->user()?->id;
        $currentUserRole = $this->owner_id === $currentUserId
            ? 'owner'
            : ($this->members->firstWhere('id', $currentUserId)?->pivot->role ?? 'none');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'key' => $this->key,
            'description' => $this->description,
            'status' => $this->status,
            'current_user_role' => $currentUserRole,
            'owner' => new UserResource($this->whenLoaded('owner')),
            'members_count' => $this->members_count ?? $this->members()->count(),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
