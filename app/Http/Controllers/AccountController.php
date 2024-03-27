<?php

namespace App\Http\Controllers;

use App\Http\Resources\{ImageResource, SupplierResource, CountryResource};
use App\Models\{Image, Country, Supplier};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Validator, DB, Hash};
use Inertia\Inertia;
use App\Helpers\ImageManager;

class AccountController extends Controller
{
    use ImageManager;
    public function index()
    {
        $user = Auth::user();
        $image = Image::where(['entity_id' => $user->id, 'entity_type' => 'supplier'])->first();
        $countries = Country::get();
        return Inertia::render('Account/Index', [
            'user' => new SupplierResource($user),
            'image' => new ImageResource($image),
            'countries' => CountryResource::collection($countries)
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'supplier_name' => 'required|string',
                'password' => 'required',
            ]);
            if (!Hash::check($request->password, auth()->user()->password)) {
                return back()->withErrors(["message" => "Password Doesn't match!"]);
            }
            if ($request->id) {
                Supplier::where('id', $request->id)->updateOrCreate(
                    ['id' => $request->id],
                    [
                        'supplier_name' => $request->supplier_name,
                        'password' => ($request->password ?  Hash::make($request->password) : auth()->user()->password),
                    ]
                );
                return redirect('/account')->with('flash',  updateMessage('User'));
            }
        } catch (\Exception $e) {
            return back()->withErrors(["message" => $e->getMessage()]);
        }
    }

    public function image(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false]);
        }
        try {
            DB::beginTransaction();
            $path = public_path("/images/supplier");
            !is_dir($path) &&  mkdir($path, 0777, true);
            if ($file = $request->file('image')) {
                $fileData = $this->uploadImage($path, $file);
                $image = Image::where(['entity_id' => $request->id, 'entity_type' => 'supplier'])->first();
                if ($image) {
                    if (file_exists($image->profile_image)) {
                        unlink($image->profile_image);
                    }
                }
                Image::updateOrCreate(
                    ['entity_id' => $request->id],
                    [
                        'name' => $fileData['fileName'],
                        'type' => $fileData['fileType'],
                        'path' => $fileData['filePath'],
                        'size' => $fileData['fileSize'],
                        'entity_type' => 'supplier',
                        'entity_id' => $request->id,
                    ]
                );
            }
            DB::commit();
            return redirect()->back()->with('flash', createMessage('Profile Image'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function informationStore(Request $request)
    {
        $request->validate([
            'name'   => 'required|string',
            'company_name'    => 'required',
            'company_name'    => 'required',
            'name'            => 'required',
            'phone'           => 'required',
            'contact_email'   => 'required',
            'rfq_email'       => 'required',
            'skype'           => 'required',
            'linkedin'        => 'required',
            'aol'             => 'required',
            'mailing_address'  => 'required',
            'city'            => 'required',
            'zipcode'         => 'required',
            'final_id'        => 'required',
            'country'         => 'required',
            'traffic_details' => 'required',
            'name_of_contact' => 'required',
        ]);
        try {
            if ($request->id) {
                Supplier::where('id', $request->id)->updateOrCreate(
                    ['id' => $request->id],
                    [
                        'supplier_name' => $request->name,
                        'contact_number' => $request->phone,
                        'email_address' => $request->contact_email,
                        'rfq_email' => $request->rfq_email,
                        'final_id' => $request->final_id,
                        'skype_profile' => $request->skype,
                        'linkedin_profile' => $request->linkedin,
                        'aol' => $request->aol,
                        'mailing_address' => $request->mailing_address,
                        'city' => $request->city,
                        'state' => $request->state,
                        'country_id' => $request->country,
                        'zipcode' => $request->zipcode,
                        'final_id' => $request->final_id,
                        'traffic_details' => $request->traffic_details,
                        'name_of_contact' => $request->name_of_contact,

                    ]
                );
                return redirect('/account')->with('flash',  updateMessage('User'));
            }
        } catch (\Exception $e) {
            return back()->withErrors(["message" => $e->getMessage()]);
        }
    }
}