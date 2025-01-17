<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $casts = [
        'service' => 'array', // Decode the JSON into an array
    ];

    public function getServiceDetailsAttribute()
    {
        // Ensure the service field is an array, decode if it's a string
        $serviceArray = is_array($this->service) ? $this->service : json_decode($this->service, true);

        $serviceDetails = [];

        // If the service array is not empty, loop through and fetch the details
        if (!empty($serviceArray)) {
            foreach ($serviceArray as $serviceItem) {
                $selectedServiceId = $serviceItem['selectedService'] ?? null;
                $package = $serviceItem['package'] ?? null;
                $startingDate = $serviceItem['startDate'] ?? null;
                $endingDate = $serviceItem['endDate'] ?? null;

                if ($selectedServiceId) {
                    // Fetch the service details for each selectedService ID
                    $serviceDetail = ServiceDetails::find($selectedServiceId);

                    if ($serviceDetail) {
                        $serviceDetails[] = [
                            'name' => $serviceDetail->name,
                            'price' => $serviceDetail->price,
                            'package' => $package,
                            'startingDate' => $startingDate,
                            'endingDate' => $endingDate,
                        ];
                    }
                }
            }
        }

        return $serviceDetails; // Return all the service details
    }
}
