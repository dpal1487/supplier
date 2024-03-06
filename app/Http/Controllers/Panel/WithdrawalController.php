<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Models\WalletHistory;
use JWTAuth;
use App\Http\Resources\WithdrawalResource;
class WithdrawalController extends Controller
{
    public function index()
    {
        $user =  JwtAuth::user();
        $histories = WalletHistory::where('user_id',$user->id)->paginate(20);
           if(count($histories)>0){
             return WithdrawalResource::collection($histories)->additional(['success'=>true]);
           } else {
            return response()->json(['data'=>null,'meta'=>null,'success'=>false]);
           }
    }
}

