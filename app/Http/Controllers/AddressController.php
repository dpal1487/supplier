<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Http\Resources\StateResource;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function getState(Request $request)
    {
        $states = State::where('country_id', $request->country_id)->get();
        $cities = City::where('country_id', $request->country_id)->get();

        return response()->json([
            'states' => StateResource::collection($states),
            'cities' => CityResource::collection($cities),
            'success' => true,
        ]);
    }

    public function getCity(Request $request)
    {
        $cities = City::where('state_id', $request->state_id)->get();
        return response()->json([
            'cities' => CityResource::collection($cities),
            'success' => true,
        ]);
    }
}
