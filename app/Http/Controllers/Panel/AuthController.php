<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Resources\Panel\UserResource;
use App\Models\{User, ReferralUser, Wallet, WalletHistory};
use Illuminate\Support\Facades\{Auth, DB, Mail, Cache, Hash, Redis, Validator, Sanctum};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\RegistrationMail;
use Exception;
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
        $validator = Validator::make($request->all(), [
            'email' => 'email',
            'password' =>  Password::min(8),
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST);
        }
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json(['message' => 'Invalid email addres or password', 'success' => false], Response::HTTP_UNAUTHORIZED);
            }
            $user = Auth::user();
            if ($user->email_verified_at) {
                if ($user->status !== 1) {
                    return response()->json([
                        'message' => 'Your account is not active. Please contact administrator.',
                        'success' => false,
                    ], Response::HTTP_UNAUTHORIZED);
                }
                $user->tokens()->delete();
                $token = $user->createToken('api')->plainTextToken;
                return response()->json([
                    'user' => new UserResource($user),
                    'success' => true,
                    'access_token' => $token,
                    'email_verified' => true,
                    'message' => 'Successfully login',
                ], Response::HTTP_OK);
            }
            return response()->json([
                'data' => [
                    'email_verified' => false,
                ],
                'message' => 'Please verify your email address using otp sent to your registered email.',
                'success' => false
            ], Response::HTTP_UNAUTHORIZED);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(['access_token' => $user->createToken('api')->plainTextToken]);
    }
    public function sendOTP(Request  $request)
    {
        $email = $request->email;
        // Generate OTP
        $otp = rand(100000, 999999);

        // Store OTP in cache or database for verification
        // For example, you can use Laravel Cache:
        cache(['otp_' . $email => $otp], now()->addMinutes(15)); // Cache OTP for 15 minutes
        // Send OTP via email
        Mail::raw("Your OTP for verification is: $otp", function ($message) use ($email) {
            $message->to($email)->subject('OTP Verification');
        });
        return response()->json(['message' => 'OTP sent successfully', 'success' => true], Response::HTTP_OK);
    }

    // public function sendOtp(Request $request)
    // {
    //     $email = $request->email;
    //     $otp = rand(100000, 999999); // Generate a 6-digit OTP
    //     // Store OTP in Redis with a 5-minute expiration
    //     $opt_session = Redis::setex(“otp: $email”, 300, $otp);

    //     return $opt_session;
    //     // Send OTP by email
    //     Mail::to($email)->send(new OtpMail($otp));
    //     //  return response()->json([‘message’ => ‘OTP sent successfully’]);
    // }
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
                'password' =>  ['required', Password::min(8)],
                'mobile' => 'required|numeric|digits:10|unique:users,mobile',
                'country' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
            } else {
                $token = Str::random(40);
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' =>  Hash::make($request->password),
                    'mobile' => $request->mobile,
                    'country_id' => $request->country,
                    'api_token' => $token,
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
        return $request;
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



    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }
        $email = $request->email;
        $otp = $request->otp;
        // Check if OTP exists in cache
        if (!Cache::has('otp_' . $email)) {
            return response()->json(['message' => 'OTP not found or expired', 'success' => false], Response::HTTP_BAD_REQUEST);
        }
        // Get the OTP from cache
        $cachedOTP = Cache::get('otp_' . $email);
        // Verify if OTP matches
        if ($cachedOTP != $otp) {
            return response()->json(['message' => 'Invalid OTP', 'success' => false], 400);
        }
        // Clear the OTP from cache after successful verification
        Cache::forget('otp_' . $email);
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found', 'success' => false], 404);
        }

        $user->email_verified_at = now(); // Assuming you're using Laravel's built-in email verification feature
        $user->save();
        return response()->json(['message' => 'OTP verified successfully', 'success' => true], Response::HTTP_OK);
    }

    public function getAuthenticatedUser(Request $request)
    {

        if (Auth::check()) {
            return response()->json(['data' => new UserResource(Auth::user()), 'success' => true], Response::HTTP_OK);
        }
        return '';
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
