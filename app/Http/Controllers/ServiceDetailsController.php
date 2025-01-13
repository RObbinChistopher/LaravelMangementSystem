<?php

namespace App\Http\Controllers;

use App\Http\Resources\serviceDetailResource;
use App\Models\ServiceDetails;
use Illuminate\Http\Request;

class ServiceDetailsController extends Controller
{
    public function allServiceDetailsData()
    {
        $service = ServiceDetails::all();
        return serviceDetailResource::collection($service);
    }
    public function showService()
    {
        $service = ServiceDetails::orderBy('id', 'desc')->paginate(10);
        return serviceDetailResource::collection($service);
    }

    public function storeServiceDetails(Request $request) {
        $service = new ServiceDetails();
        $service->name = $request->name;
        $service->price = $request->price;
        $service->tax = $request->tax;
        $service->save();
        return response()->json(['message' => 'Service Details create successfully']);
    }
    public function editServiceDetails(string $id)
    {
        $service = ServiceDetails::findOrFail($id);
        return new serviceDetailResource($service);
    }
    public function updateServiceDetails(Request $request, string $id) {
        $service = ServiceDetails::findOrFail($id);
        $service->name = $request->name;
        $service->price = $request->price;
        $service->tax = $request->tax;
        $service->save();
        return response()->json(['message' => 'Service Details create successfully']);
    }
    public function deleteServiceDetails(string $id)
    {
        $service = ServiceDetails::findOrFail($id);
        $service->delete();
        return response()->json(['message' => 'Service Details Delete Successfully']);
    }
}
