<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceEmail;


class ServiceController extends Controller
{

    use ImageUploadTrait;
    public function sendServiceEmail(Request $request)
    {
        $task = $request->only([
            'client_name',
            'email',
            'phone',
            'service',
            'package',
            'total_payment',
            'initial_payment',
            'remaining_payment',
            'payment_status',
            'starting_date',
            'ending_date',
            'services',
        ]);


        // Get recipient email
        $recipientEmail = $task['email'];

        // Send email using a Mailable class
        Mail::to($recipientEmail)->send(new InvoiceEmail($task));

        return response()->json(['message' => 'Email sent successfully']);
    }
    public function storeService(Request $request)
    {
        $service = new Service();
        $invoice = $this->Uploadimage($request, 'invoice', 'invoice');
        $service->client_name = $request->client_name;
        $service->client_last_name = $request->client_last_name;
        $service->email = $request->email;
        $service->phone = $request->phone;
        $services = json_decode($request->service, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid service data format'], 400);
        }

        $service->service = json_encode($services);
        $service->service_tax = $request->service_tax;
        $service->payment_status = $request->payment_status;
        $service->invoice = $invoice;
        $service->total_payment = $request->total_payment;
        $service->initial_payment = $request->initial_payment;
        $service->remaining_payment = $request->remaining_payment;
        $service->description = $request->description;
        $startingDate = Carbon::now();
        if ($request->has('starting_date') && $request->starting_date) {
            $startingDate = Carbon::parse($request->starting_date);
        }
        $service->starting_date = $startingDate->format('Y-m-d');
        foreach ($services as $serviceData) {
            $package = $serviceData['package'];
            switch ($package) {
                case '1week':
                    $endingDate = $startingDate->addWeek();
                    break;
                case '3week':
                    $endingDate = $startingDate->addWeeks(3);
                    break;
                case '1month':
                    $endingDate = $startingDate->addMonth();
                    break;
                case '3month':
                    $endingDate = $startingDate->addMonths(3);
                    break;
                case '6month':
                    $endingDate = $startingDate->addMonths(6);
                    break;
                case '1year':
                    $endingDate = $startingDate->addYear();
                    break;
                default:
                    return response()->json(['error' => 'Invalid package type'], 400);
            }
            $formattedEndingDate = $endingDate->format('Y-m-d');
            $service->ending_date = $formattedEndingDate;
        }
        $service->save();
        return response()->json(['success' => 'Service created successfully']);
    }



    public function showService()
    {
        $service = Service::orderBy('id', 'desc')->paginate(10);
        return ServiceResource::collection($service);
    }
    public function editService(string $id)
    {
        $service = Service::findOrFail($id);
        return new ServiceResource($service);
    }
    public function updateService(Request $request, string $id)
    {
        $service = Service::findOrFail($id);
        $invoice = $service->invoice;
        if ($request->hasFile('invoice')) {
            $invoice = $this->Updateimage($request, 'invoice', 'invoice', $service->invoice);
        }
        $service->client_name = $request->client_name;
        $service->client_last_name = $request->client_last_name;
        $service->email = $request->email;
        $service->phone = $request->phone;
        $services = json_decode($request->service, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid service data format'], 400);
        }
        $service->service = json_encode($services);

        $service->service_tax = $request->service_tax;
        $service->payment_status = $request->payment_status;
        $service->invoice = $invoice;
        $service->total_payment = $request->total_payment;
        $service->initial_payment = $request->initial_payment;
        $service->remaining_payment = $request->remaining_payment;
        $service->description = $request->description;
        $startingDate = Carbon::now();
        if ($request->has('starting_date') && $request->starting_date) {
            $startingDate = Carbon::parse($request->starting_date);
        }
        $service->starting_date = $startingDate->format('Y-m-d');
        foreach ($services as $serviceData) {
            $package = $serviceData['package'];
            switch ($package) {
                case '1week':
                    $endingDate = $startingDate->addWeek();
                    break;
                case '3week':
                    $endingDate = $startingDate->addWeeks(3);
                    break;
                case '1month':
                    $endingDate = $startingDate->addMonth();
                    break;
                case '3month':
                    $endingDate = $startingDate->addMonths(3);
                    break;
                case '6month':
                    $endingDate = $startingDate->addMonths(6);
                    break;
                case '1year':
                    $endingDate = $startingDate->addYear();
                    break;
                default:
                    return response()->json(['error' => 'Invalid package type'], 400);
            }
            $formattedEndingDate = $endingDate->format('Y-m-d');
            $service->ending_date = $formattedEndingDate;
        }
        $service->save();
        return response()->json(['success' => 'Service Update successfully']);
    }
    public function deleteService(string $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return response()->json(['success' => 'Service Delete successfully']);
    }
    public function generatePDF(Request $request)
    {
        // No need to decode `services` if it's already an array
        $services = $request->services;

        // Build the data array
        $data = [
            'client_name' => $request->client_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'total_payment' => $request->total_payment,
            'initial_payment' => $request->initial_payment,
            'remaining_payment' => $request->remaining_payment,
            'payment_status' => $request->payment_status,
            'starting_date' => $request->starting_date,
            'ending_date' => $request->ending_date,
            'services' => $services, // Pass `services` directly
        ];

        // Load a Blade view to generate the PDF
        $pdf = Pdf::loadView('pdf.invoice', $data);

        // Return the PDF as a download
        return response()->stream(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="invoice.pdf"',
        ]);
    }
    public function filttleByService(string $service)
    {
        $services = Service::where('service', $service)->paginate(10);

        return ServiceResource::collection($services);
    }
    public function filteByServiceStatus(string $status)
    {
        $services = Service::where('payment_status', $status)->paginate(10);
        return ServiceResource::collection($services);
    }
    public function ServiceSearch(Request $request)
    {
        $query = $request->input('query');

        $results = Service::where('service', 'like', "%$query%")
            ->orWhere('client_name', 'like', "%$query%")
            ->orWhere('package', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->limit(9)
            ->get();

        return ServiceResource::collection($results);
    }
    // public function alertMessageOnEndPackage()
    // {
    //     $currentDate = Carbon::now();
    //     $services = Service::where('payment_status', 'pending')
    //         ->where(function ($query) use ($currentDate) {
    //             $query->where(function ($subQuery) use ($currentDate) {
    //                 $subQuery->where('package', '1-week')
    //                     ->whereDate('ending_date', '>=', $currentDate->toDateString())
    //                     ->whereDate('ending_date', '<=', $currentDate->copy()->addDays(2)->toDateString());
    //             })
    //                 ->orWhere(function ($subQuery) use ($currentDate) {
    //                     $subQuery->where('package', '!=', '1-week')
    //                         ->whereDate('ending_date', '>=', $currentDate->toDateString())
    //                         ->whereDate('ending_date', '<=', $currentDate->copy()->addDays(1)->toDateString());
    //                 });
    //         })
    //         ->get();

    //     return ServiceResource::collection($services);
    // }
    public function alertMessageOnEndPackage()
    {
        $currentDate = Carbon::now();
        $services = Service::where('payment_status', 'pending')
            ->where(function ($query) use ($currentDate) {
                $query->where(function ($subQuery) use ($currentDate) {
                    $subQuery->where('package', '1week')
                        ->whereDate('ending_date', '>=', $currentDate->toDateString())
                        ->whereDate('ending_date', '<=', $currentDate->copy()->addDays(3)->toDateString());
                })
                    ->orWhere(function ($subQuery) use ($currentDate) {
                        $subQuery->where('package', '!=', '1week')
                            ->whereDate('ending_date', '>=', $currentDate->toDateString())
                            ->whereDate('ending_date', '<=', $currentDate->copy()->addDays(7)->toDateString());
                    });
            })
            ->get();

        return ServiceResource::collection($services);
    }

    public function AllshowService()
    {
        $service = Service::all();
        return ServiceResource::collection($service);
    }
}
