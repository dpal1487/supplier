<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Address;
use App\Models\PanelSurvey;
use App\Models\ReferralUser;
use App\Models\NewsLetter;
use App\Models\Report;
use App\Models\ReportType;
use App\Models\FeedbackCategory;
use JWTAuth;
use App\Http\Resources\PanelSurveyResource;
use App\Http\Resources\NewsLetterResource;
class DashboardController extends Controller
{
	private $data;
	public function index(){
		//return $this->getTokenId();
		$wallet = Wallet::where(['user_id'=>$this->getTokenId()])->first();
		$wallet = array(
			'id'=>$wallet->id,
            'date'=>$wallet->date,
            'points'=>$wallet->points,
            'cash_balance'=>$wallet->cash_balance
        );
		return response()->json(['wallet'=>$wallet]);
	}

	public function dailySurvey(){
        
    $user =  JWTAuth::user();
    $address = Address::where(['user_id'=>$user->id])->first();
    $panel_surveys = PanelSurvey::with(['project'=> function($query) use ($address) {
        $query->where('status','=','open');
        $query->where('country','=',$address->country_id);
    },])->paginate(10);

    if(count($panel_surveys)>0){
         return PanelSurveyResource::collection($panel_surveys)->additional(['success'=>true]);
       } else {
        return response()->json(['data'=>null,'meta'=>null,'success'=>false]);
       }

    }

    public function newsLetter(){

        $news_letters = NewsLetter::where(['status'=>'1'])->paginate(10);

        if(count($news_letters)>0){
         return NewsLetterResource::collection($news_letters)->additional(['success'=>true]);
       } else {
        return response()->json(['data'=>null,'meta'=>null,'success'=>false]);
       }
    }

    public function storeReport(Request $request){
        
        $user = JwtAuth::user();
        $report = New Report();
        $report->user_id = $user->id;
        $report->type_id = '1';
        $report->source_id = $request->Id;
        $result  = $report->save();
        if($result) {
            return response()->json(['message'=>'Report Submitted Successfully.','success'=>true]);
        } 
    }

    public function referralUser(){
        $user = JwtAuth::user();
        $result = ReferralUser::where(['user_id'=>$user->id])->get();
        if($result) {
            return response()->json(['data'=>count($result),'success'=>true]);
        } 
        }
    public function feedbackCategory(){
    $feedback_category = FeedbackCategory::all();
       if($feedback_category) {
                return response()->json(['success'=>true,'data'=>$feedback_category]);
            }
   }

}