<?php

namespace App\Http\Controllers\panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FeedbackCategory;
use App\Models\Feedback;
use JWTAuth;
use App\Http\Resources\FeedbackResource;
class FeedbackController extends Controller
{
   public function index(){
      /*$result = Feedback::orderBy('id','desc')->get();
      if(count($result)>0){
         return response()->json(['success'=>true,'data'=>$result]);
      }*/
      $feedbacks = Feedback::orderBy('id','desc')->get();
      if(count($feedbacks)>0){
            return FeedbackResource::collection($feedbacks)->additional(['success'=>true]);
           }
        else {
            return response()->json(['data'=>null,'meta'=>null,'success'=>false]);
        } 
   }

   public function category(){
    $feedback_category = FeedbackCategory::all();
       if($feedback_category) {
                return response()->json(['success'=>true,'data'=>$feedback_category]);
            }
       }

    public function store(Request $request)
    {
    	//return $request->all();
        $user = JwtAuth::user();
        $feedback = New Feedback();
        $feedback->user_id = $user->id;
        $feedback->category = $request->category;
        $feedback->rating = $request->rating;
        $feedback->feedback = $request->feedback;
        $result = $feedback->save();
        if($result) {
            return response()->json(['success'=>true,'message'=>'Thanks for your feedback.']);
        }
    }
}
