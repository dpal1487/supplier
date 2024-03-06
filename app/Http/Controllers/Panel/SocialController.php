<?php

namespace App\Http\Controllers\Panel;

use Auth;
use Exception;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    protected $providers = ['github', 'facebook', 'google', 'twitter'];

    public function index()
    {
        return view('welcome');
        # code...
    }
    public function SocialSignup($provider)
    {


        // return $provider;
        // Socialite will pick response data automatic
        $user = Socialite::driver($provider)->stateless()->redirect();

        return response()->json($user);
    }


    public function loginWithSocial($provider)
    {
        try {

            $user = Socialite::driver($provider)->user();
            $isUser = User::where('facebook_id', $user->id)->first();

            if ($isUser) {
                Auth::login($isUser);
                return redirect('/dashboard');
            } else {
                $createUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'fb_id' => $user->id,
                    'password' => encrypt('admin@123')
                ]);

                Auth::login($createUser);
                return redirect('/dashboard');
            }
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
