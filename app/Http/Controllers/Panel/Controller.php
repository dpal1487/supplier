<?php

namespace App\Http\Controllers\Panel;

use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function uid()
    {
        $user = Auth::guard('api')->user();
        return $user->id;
    }
    public function user()
    {
        return Auth::guard('api')->user();
    }
    public function getTokenId()
    {
        $user = Auth::user();
        $token = $user->currentAccessToken();

        if ($token) {
            return $token->tokenable_id;
        } else {
            return response()->json(['error' => 'Token not found.'], 404);
        }
    }
}
