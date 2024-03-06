<?php

namespace App\Http\Controllers\Website;

use Validator;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::paginate(10);
        if (count($services) > 0) {
            return ServiceResource::collection($services);
        } else {
            return response()->json(['data' => null, 'success' => true]);
        }
    }
    public function singleService($slug)
    {
        $service = Service::with('image')->where('slug', $slug)->first();

        if ($service) {
            return response()->json(['data' => new ServiceResource($service), 'success' => true]);
        } else {
            return response()->json(['data' => null, 'success' => true]);
        }
    }
}
