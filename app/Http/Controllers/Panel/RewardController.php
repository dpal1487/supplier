<?php

namespace App\Http\Controllers\Panel;

use App\Models\WalletHistory;
use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Resources\Panel\WalletHistoryResource;
class RewardController extends Controller
{

    public function index()
    {

        $user = JWTAuth::user();
        $credit = WalletHistory::where(['user_id'=>$user->id,'status'=>'Credit'])->sum('current_points');
        $debit = WalletHistory::where(['user_id'=>$user->id,'status'=>'Debit'])->sum('current_points');
        $available = $credit- $debit;
        $wallet_histories = WalletHistory::where(['user_id'=>$user->id,'status'=>'Credit'])->paginate(20);

        if(count($wallet_histories)>0){
            return WalletHistoryResource::collection($wallet_histories)->additional(['success'=>true,'credit'=>$credit,'debit'=>$debit,'available'=>$available]);
           } else {
            return response()->json(['data'=>null,'meta'=>null,'success'=>false]);
           }

         }
     }
