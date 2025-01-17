<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamMembersResource extends JsonResource
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
            'team_id' => $this->team_id ?? "",
            'member_id' => $this->member_id ?? "",
            'project_id' => $this->project_id ?? "",
            'assigned_date' => $this->assigned_date ?? "",
            'users' => $this->users ? $this->users->name : null,
            'user_position' => $this->users ? $this->users->position : null,
            'team' => $this->team ? $this->team->team_name : null,
            'project' => $this->project ? $this->project->name : null,
            'deadline' => $this->project ? $this->project->deadline : null,
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : "", // Formatting created_at
        ];
    }
}
