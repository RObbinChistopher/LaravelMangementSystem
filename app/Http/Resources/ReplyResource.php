<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
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
            'message' => $this->message,
            'status' => $this->status,
            'role' => $this->role,
            'user_name' => $this->user ? $this->user->name : null,
            'user_role' => $this->user ? $this->user->role   : null,
            'user_email' => $this->user ? $this->user->email   : null,
            'created_at' => $this->created_at ? $this->created_at->format('D M d, Y h:i A') : "", // Formatting created_at
            'updated_at' => $this->updated_at ? $this->updated_at->format('D M d, Y h:i A') : "", // Formatting created_at
        ];
    }
}
