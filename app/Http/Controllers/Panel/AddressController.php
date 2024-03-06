<?php

namespace App\Http\Controllers\Panel;

use JWTAuth;
use Validator;
use App\Models\User;
use App\Models\State;
use App\Models\Address;
use App\Models\Country;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Resources\AddressResource;
use App\Http\Resources\CountryListResource;
use App\Http\Resources\CountryResource;
use App\Models\City;

class AddressController extends Controller
{
    public function index()
    {
        $user = JwtAuth::user();

        $countries = Country::with('states')->get();

        // return  new AddressResource($user);

        $address = Address::with('address.country', 'address.state')->where('user_id', $user->id)->first();

        return response()->json(['address' =>  new AddressResource($user), 'countries' => CountryResource::collection($countries), 'success' => true]);
    }
    public function update(Request $request)
    {

        $user = JwtAuth::user();

        $validator = Validator::make($request->all(), [
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        } else {
            $status = Address::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'address' => $request->address,
                    'country_id' => $request->country,
                    'state_id' => $request->state,
                    'city' => $request->city,
                    'pincode' => $request->pincode
                ]
            );
            if ($status) {
                return response()->json(['message' => 'Address has been updated successfully!', 'success' => true]);
            }
            return response()->json(['message' => 'Address not updated please try again.', 'success' => false]);
        }
    }
    public function getStateByCountryId(Request $request)
    {
        $data = State::where('country_id', $request->country_id)->get();
        return response()->json(['data' => $data]);
    }
    public function getCityByCountryId(Request $request)
    {
        $data = City::where('state_id', $request->state_id)->get();
        return response()->json(['data' => $data]);
    }
    public function getCountries()
    {
        return CountryListResource::collection(Country::get());
    }
}
