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
        // Get all service details
        $serviceDetails = $this->serviceDetails; // This will call the `getServiceDetailsAttribute()` method

        return [
            'id' => $this->id,
            'client_name' => $this->client_name ?? "",
            'client_last_name' => $this->client_last_name ?? "",
            'email' => $this->email ?? "",
            'phone' => $this->phone ?? "",
            'service' => $this->service ?? "",
            'service_tax' => $this->service_tax ?? "",
            'package' => $this->package ?? "",
            'total_payment' => $this->total_payment ?? "",
            'initial_payment' => $this->initial_payment ?? "",
            'remaining_payment' => $this->remaining_payment ?? "",
            'payment_status' => $this->payment_status ?? "",
            'starting_date' => $this->starting_date,
            'ending_date' => $this->ending_date,
            'description' => $this->description,
            'invoice' => $this->invoice,
            // Include all service details
            'services' => $serviceDetails, // This will now be an array of all services
        ];
    }
}
