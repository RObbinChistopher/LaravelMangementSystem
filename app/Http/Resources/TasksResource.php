<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
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
            'milestoneId' => $this->milestoneId ?? "",
            'userId' => $this->userId ?? "",
            'deadline' => $this->deadline ?? "",
            'priority' => $this->priority ?? "",
            'status' => $this->status ?? "",
            'description' => $this->description ?? "",
            'milestones_name' => $this->milestones ? $this->milestones->name : null,
            'User_name' => $this->User ? $this->User->name : null,
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : "", // Formatting created_at
        ];
    }
}
