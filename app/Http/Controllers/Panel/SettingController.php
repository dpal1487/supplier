<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use Hash;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Password;
use Validator;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::where('user_id', Auth::user()->id)->first();
        return response()->json(['data' => $setting, 'success' => true]);
    }
    /* public function createChangePassword()
    {
    	return view('backend.account.change-password');
    }*/
    public function updateChangePassword(Request $request)
    {
        $user = Auth::user();
        //Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:4',
            'password' => Password::min(8),
            'confirm_password' => 'required|min:4|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST);
        } else {

            if ($user = User::where(['id' => auth()->user()->id])->first()) {
                if (Hash::check($request->old_password, $user->password)) {
                    if (User::where('id', $this->getTokenId())->update(['password' => Hash::make($request->get('password'))])) {
                        return response()->json(['success' => true, 'message' => 'Your password has been changed successfully']);
                    } else {
                        return response()->json(['success' => false, 'message' => 'Something went worng. Try again']);
                    }
                }
                return response()->json(['success' => false, 'message' => 'Please enter valid current password.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Something went worng. Try again']);
            }
        }
    }
    public function updateSetting(Request $request)
    {

        if ($request->promotion == true) {
            $prom_recom_status = 1;
        } else {
            $prom_recom_status = null;
        }
        if ($request->withdrawal == true) {
            $withdrawal_status = 1;
        } else {
            $withdrawal_status = null;
        }
        if ($request->show_profile == true) {
            $profile_status = 1;
        } else {
            $profile_status = null;
        }
        if ($request->notifications == true) {
            $notification_status = 1;
        } else {
            $notification_status = null;
        }
        if ($request->newsletters == true) {
            $newsletter_status = 1;
        } else {
            $newsletter_status = null;
        }
        $status = Setting::updateOrCreate(
            [
                'user_id' => Auth::user()->id
            ],
            [
                'user_id' => Auth::user()->id,
                'promotion' => $prom_recom_status,
                'withdrawal' => $withdrawal_status,
                'show_profile' => $profile_status,
                'notifications' => $notification_status,
                'newsletters' => $newsletter_status
            ]
        );

        if ($status) {
            return response()->json(['message' => 'Setting updated successfully.', 'success' => true]);
        }
    }
}