<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'client_name' => $this->client_name ?? "",
            'email' => $this->email ?? "",
            'phone' => $this->phone ?? "",
            'service' => $this->service ?? "",
            'package' => $this->package ?? "",
            'total_payment' => $this->total_payment ?? "",
            'initial_payment' => $this->initial_payment ?? "",
            'remaining_payment' => $this->remaining_payment ?? "",
            'payment_status' => $this->payment_status ?? "",
            'starting_date' => $this->starting_date,
            'ending_date' => $this->ending_date,
            'description' => $this->description,
            'invoice' => $this->invoice,
        ];
    }
}
