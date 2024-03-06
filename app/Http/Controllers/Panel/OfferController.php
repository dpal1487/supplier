<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Http\Resources\OfferResource;

class OfferController extends Controller
{
    public function index()
    {
    	$offers = Offer::paginate(20);
    	if(count($offers)>0){
         return OfferResource::collection($offers)->additional(['success'=>true]);
       } else {
        return response()->json(['data'=>null,'meta'=>null,'success'=>false]);
       }
    }
}
