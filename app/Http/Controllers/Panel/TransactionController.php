<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Models\Transaction;
use JWTAuth;
use App\Http\Resources\TransactionResource;
class TransactionController extends Controller
{
    public function index()
    {
    	$user =  JwtAuth::user();
    	$transactions = Transaction::where('user_id',$user->id)->orderBy('id','asc')->paginate(20);
           if(count($transactions)>0){
             return TransactionResource::collection($transactions)->additional(['success'=>true]);
           } else {
            return response()->json(['data'=>null,'meta'=>null,'success'=>false]);
           }
    }
}
