<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'name' => $this->name ?? "",
            'client_name' => $this->client_name ?? "",
            'deadline' => $this->deadline ?? "",
            'percentage' => $this->percentage ?? "",
            'description' => $this->description ?? "",
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : "", // Formatting created_at
        ];
    }
}
