<?php

namespace App\Http\Controllers\Panel;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Redirect;

class ProfileController extends Controller
{
    public function getUser()
    {
        $user = Auth::user();
        $user = User::where('id', $user->id)->with('image')->first();
        return response()->json(['success' => true, 'data' => $user]);
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'mobile' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        $first_name =  $request->first_name;
        $last_name =  $request->last_name;
        $gender =  $request->gender;
        $dob =  $request->dob;
        $mobile =  $request->mobile;
        $status = User::where('id', $user->id)->update(['first_name' => $first_name, 'last_name' => $last_name, 'gender' => $gender, 'dob' => $dob, 'mobile' => $mobile]);

        if ($status) {
            return response()->json(['message' => 'Profile successfully updated.', 'success' => true]);
        }
    }
    public function profileImageUpdate(Request $request)
    {
        $user = Auth::user();
        if ($request->file()) {
            $file = new FileController();
            return $file->updateProfileImage($request, $user);
        }
    }
}
