<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Resources\Panel\UserResource;
use App\Models\{User, ReferralUser, Wallet, WalletHistory};
use Illuminate\Support\Facades\{Hash, Validator, Sanctum};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\RegistrationMail;
use Exception;
use Illuminate\Support\Facades\{Auth, DB, Mail};
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Response;


class AuthController extends Controller
{
    public $token = true;
    public $data;
    private $random;
    public function __construct()
    {
        $this->random = Str::random(40);
    }
    public function authenticate(Request $request)
   {
     $credentials = $request->only('email', 'password');
        $validator = Validator::make($credentials, [
            'email' => 'email',
            'password' =>  Password::min(8),
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()],Response::HTTP_BAD_REQUEST);
        }
        if (Auth::attempt($credentials)) {
            $user = Auth::guard('panel')->user();
            $token = auth()->user()->tokens()->delete();
            $token = $user->createToken('sanctum')->plainTextToken;

            return response()->json([
                'user' => new UserResource($user),
                'success' => true,
                'access_token' => $token,
                'message' => 'Successfully login',
            ],Response::HTTP_OK)->withCookie(cookie('api_token', $token, 60 * 24));
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], Response::HTTP_UNAUTHORIZED);
   }
    public function sendOtp(Request $request)
    {
        $User = User::where(['email' => $request->email])->first();
        $title = 'All Reasearch Account - Verify your Email Address.';
        $customer_details = ['link' => 'http://localhost:3000/verify?token=' . $User->token . '&id=' . $User->id, 'email' => $User->email];
        $sendmail = Mail::to($customer_details['email'])->send(new RegistrationMail($title, $customer_details));
        return response()->json(['token' => $User->token, 'success' => true, 'message' => 'Please check your inbox to verify your email.'], 200);
    }
    public function resendVerification(Request $request)
    {

        $user = User::where(['email' => $request->email])->first();
        if ($user) {
            if ($user->email_verified != 1) {
                $title = 'All Reasearch Account - Verify your Email Address.';
                $customer_details = ['link' => 'https://panel.alrestion.com/verify?token=' . $user->token . '&id=' . $user->id, 'email' => $user->email];
                $sendmail = Mail::to($customer_details['email'])->send(new RegistrationMail($title, $customer_details));
                return response()->json(['success' => true, 'message' => 'Please check your inbox to verify your email address.'], 200);
            }
            return response()->json([
                'success' => false,
                'message' => 'Email Already Verified'
            ], 400);
        } else {
            return response()->json(['success' => false, 'message' => 'There is no account with this email'], 400);
        }
        return $user;
    }
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|unique:users,email',
                'password' =>  ['required', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
                'mobile' => 'required|numeric|digits:10|unique:users,mobile',
                'country' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
            } else {

                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' =>  Hash::make($request->password),
                    'mobile' => $request->mobile,
                    'country_id' => $request->country,
                    'ip_address' => $request->ip()
                ]);

                if (!empty($request->ref_code) && $request->ref_code != null) {
                    $Wallet = new Wallet();
                    $Wallet->user_id = $user->id;
                    $Wallet->date = date('Y-m-d H:i:s');
                    $Wallet->points = '100';
                    $Wallet->cash_balance = 100 / 500 * 1;
                    $walletResult = $Wallet->save();

                    if ($walletResult) {
                        $WalletHistory = new WalletHistory();
                        $WalletHistory->user_id = $user->id;
                        $WalletHistory->date = date('Y-m-d H:i:s');
                        $WalletHistory->points = '100';
                        $WalletHistory->status = 'Credit';
                        $WalletHistory->comments = 'Reffer to earn';
                        $WalletHistory->current_points = '100';
                        $WalletHistory->type = '1';
                        $WalletHistoryResult = $WalletHistory->save();
                    }

                    $ReferralUser = new ReferralUser();
                    $ReferralUser->user_id = $user->id;
                    $ReferralUser->save();
                }
                if ($user) {
                    $token = $user->createToken("API TOKEN")->plainTextToken;
                    $title = 'All Reasearch Account - Verify your Email Address.';
                    $customer_details = ['link' => 'https://panel.alrestion.com/verify?token=' . $token . '&id=' . $user->id, 'email' => $user->email];
                    $sendmail = Mail::to($customer_details['email'])->send(new RegistrationMail($title, $customer_details));
                    return response()->json(['success' => true, 'message' => 'Please check your inbox to verify your email address.'], 200);
                }
            }
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function verify(Request $request)
    {
        try {
            $token = $request->token;

            // Find the token in the personal_access_tokens table
            $accessToken = DB::table('personal_access_tokens')->where('token', hash('sha256', $token))->first();

            if (!$accessToken) {
                return response()->json(['success' => false, 'message' => 'Invalid token'], 400);
            }

            $user = User::find($accessToken->tokenable_id);

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            if ($user->email_verified != 1) {
                $user->email_verified = 1;
                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Thank you, Your email address has been verified. Your account is now active. Please use the link below to login to your account.'
                ], 200);
            }

            return response()->json([
                'success' => true,
                'message' => 'Thank you, Your email address is already verified.'
            ], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function getAuthenticatedUser(Request $request)
    {
        if (Auth::check()) {
            return response()->json(['data' => new UserResource(auth()->user()), 'success' => true], Response::HTTP_OK);
        }
        return response()->json(['data' => auth()->user(), 'success' => true], Response::HTTP_UNAUTHORIZED);
    }

    public function getUsername()
    {
        do {
            $code = Str::random(14);
        } while (User::where("username", "=", $code)->first());
        return $code;
    }
}