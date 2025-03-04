<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class userResource extends JsonResource
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
            'last_name' => $this->last_name ?? "",
            'role' => $this->role ?? "",
            'email' => $this->email ?? "",
            'phone' => $this->phone ?? "",
            'position' => $this->position ?? "",
            'profile' => $this->profile ?? "",
            'referral_id' => $this->referral_id ?? "",
            'bank_name' => $this->bank_name ?? "",
            'account_title' => $this->account_title ?? "",
            'account_number' => $this->account_number ?? "",
        ];
    }
}
