<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Mail\AccountMail;
use App\Models\User;
use Mail;
use Str;
use JWTAuth;
use Hash;
class EmailController extends Controller
{
    public function sendOtp(Request $request) { 
        //return $request->all();
         $validation = Validator::make($request->all(),[ 
            'email' => 'required|string',
        ]);
        if($validation->fails()){
            return response()->json(['success'=>false,'message'=>$validation->errors()->first()],200);
        } 
        else
        {
            $string=rand(1111,9999);
            $email=$request->email;
            $title = 'All Reasearch Account - '.$string.' is your verification code for secure access'; 
            $customer_details = ['otp' => $string, 'email' => $email ]; 
            $sendmail = Mail::to($customer_details['email'])->send(new AccountMail($title, $customer_details)); 
            if (empty($sendmail)) 
            { 
                if(User::where('email',$email)->first())
                {
                    $status = User::where('email',$email)->update(['reset_otp'=>$string]);
                    if ($status) {
                        return response()->json(['success' =>true,'message' => 'OTP successfully sent to '.$email, 'email'=>$email]); 
                    }  
                }
                else
                {
                    return response()->json(['success' =>false,'message' => 'This Email not exist our database.']); 
                }
            }
            else
            { 
                return $this->errorMessage();
            }
        } 
   }
    public function verifyOtp(Request $request)
    {
        $validation = Validator::make($request->all(),[ 
            'otp' => 'required|numeric|min:4',
            'email' => 'required|string',
        ]);
        if($validation->fails()){
            return response()->json(['success'=>false,'message'=>$validation->errors()->first()]);
        } 
        else
        {
            if(User::where(['email'=>$request->email,'reset_otp'=>$request->otp])->first())
            {
                return $this->passwordReset($request);
            }
            else
            {
                return response()->json(['success'=>false,'message'=>'Incorrect verification code']);
            }
        }
        return $this->errorMessage();
    }
    public function passwordReset($request){
        $validation = Validator::make($request->all(),[ 
            'otp' => 'required|numeric|min:4',
            'email' => 'required|string',
            'password' => 'required|min:8',
        ]);
        if($validation->fails()){
            return response()->json(['success'=>false,'message'=>$validation->errors()->first()]);
        } 
        else
        {  
            $status = User::where(['email'=>$request->email,'reset_otp'=>$request->otp])->update(['password'=>Hash::make($request->password), 'reset_otp'=>0]);

                if($status)
                {
                    return response()->json(['success' =>true,'message' =>'Your password has been updated successfully']);
                }   
                else
                {
                    return response()->json(['success'=>false,'message'=>'Something went wrong']);
                }
            }
        return $this->errorMessage();
    }
}
