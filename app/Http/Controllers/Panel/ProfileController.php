<?php

namespace App\Http\Controllers\Panel;

use App\Http\Resources\Panel\UserResource;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use Redirect;

class ProfileController extends Controller
{
    public function getUser()
    {
        $user = Auth::user();
        $user = User::where('id', $user->id)->first();
        return response()->json(['success' => true, 'data' => new UserResource($user)]);
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
        try {
            $status = User::where('id', $user->id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'date_of_birth' => $request->dob,
                'mobile' => $request->mobile
            ]);

            if ($status) {
                return response()->json(['message' => 'Profile successfully updated.', 'success' => true], Response::HTTP_OK);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'success' => false], Response::HTTP_BAD_REQUEST);
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