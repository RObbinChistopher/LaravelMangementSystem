<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MilestoneResource extends JsonResource
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
            'projectId' => $this->projectId ?? "",
            'deadline' => $this->deadline ?? "",
            'status' => $this->status ?? "",
            'description' => $this->description ?? "",
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : "",
            'project_name' => $this->project ? $this->project->name : null,
        ];
    }
}
