<?php

namespace App\Http\Controllers\Panel;

use App\Models\Survey;
use App\Models\Projects;
use App\Models\PanelSurvey;
use App\Models\PanelRespondent;
use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Resources\Panel\SurveyResource;
class SurveyController extends Controller
{
    private $data;
    public function index(){

    $user =  JWTAuth::user();
    $panel_respondents = PanelRespondent::where('uid',$user->id)->get();
    if(count($panel_respondents)>0){
        $attempt = PanelRespondent::where('uid',$user->id)->count();
        $complete = PanelRespondent::where(['uid'=>$user->id,'status'=>'complete'])->count();
        $terminate = PanelRespondent::where(['uid'=>$user->id,'status'=>'terminate'])->count();
        foreach($panel_respondents as $panel_respondent){
            $this->data[] = array(
                'survey_id'=>$panel_respondent->survey_id
            );
        }
        $available = $panel_surveys = PanelSurvey::whereNotIn('id',$this->data)->count();
        $panel_surveys = PanelSurvey::whereNotIn('id',$this->data)->with(['project'=> function($query) {
            return $query->where('status','=','open');
        },])->get();
        if(count($panel_surveys)>0){
             return PanelSurveyResource::collection($panel_surveys)->additional(['success'=>true,'complete'=>$complete,'terminate'=>$terminate,'available'=>$available,'attempt'=>$attempt]);
           } else {
            return response()->json(['data'=>null,'meta'=>null,'success'=>false]);
           }
    } else {
        $attempt = PanelRespondent::where('uid',$user->id)->count();
        $complete = PanelRespondent::where(['uid'=>$user->id,'status'=>'complete'])->count();
        $terminate = PanelRespondent::where(['uid'=>$user->id,'status'=>'terminate'])->count();
        /*foreach($panel_respondents as $panel_respondent){
            $this->data[] = array(
                'survey_id'=>$panel_respondent->survey_id
            );
        }*/
        $available = $panel_surveys = PanelSurvey::count();
        $panel_surveys = PanelSurvey::with(['project'=> function($query) {
            return $query->where('status','=','open');
        },])->get();
        if(count($panel_surveys)>0){
             return PanelSurveyResource::collection($panel_surveys)->additional(['success'=>true,'complete'=>$complete,'terminate'=>$terminate,'available'=>$available,'attempt'=>$attempt]);
           } else {
            return response()->json(['data'=>null,'meta'=>null,'success'=>false]);
           }
    }
}


}
