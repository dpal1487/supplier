<?php

namespace App\Http\Controllers\Panel;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Models\{User, State, Address, Country, UserAddress, City};
use App\Http\Resources\Panel\{AddressResource, CountryListResource, CountryResource};

class AddressController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $countries = Country::with('states')->get();

        $address = Address::where(['entity_id' => $user->id, 'entity_type' => 'user'])->first();

        return response()->json([
            'address' => $address  ?   new AddressResource($address) : null,
            'countries' => CountryResource::collection($countries),
            'success' => true
        ]);
    }
    public function update(Request $request)
    {

        $user = Auth::user();

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
                ['entity_id' => $user->id],
                [
                    'entity_type' => 'user',
                    'entity_id' => $user->id,
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