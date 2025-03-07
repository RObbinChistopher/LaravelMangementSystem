<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            'team_name' => $this->team_name ?? "",
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : "", // Formatting created_at
        ];
    }
}
