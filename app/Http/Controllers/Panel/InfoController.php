<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Models\{Industries ,Question ,Answer , Industry, UserInformation ,User};
use Auth;
use Validator;
use Redirect;
class InfoController extends Controller
{
    private $data=array(), $answers;
    public function index(){
    	$industries = Industry::with('image','questions','questions.userinformations')->get();
        foreach($industries as $indistry)
        {
            $this->data[]=array(
                'id'=>$indistry->id,
                'name'=>$indistry->name,
                'image'=>$indistry->image,
                'questions'=>count($indistry->questions)
            );

        }

        return response()->json(['data'=>$this->data,'success'=>true]);
    }
    public function getProfile($id)
    {
        $userData='';
        $data=null;
        $isSelected = false;
    	$user = Auth::user();
        $industry = Industries::find($id);
        $questions = Question::where('industry_id',$id)->with('answers')->get();
        if($questions!=null){
            foreach($questions as $question){
            $userData=UserInformation::where(['question_id'=>$question->id,'user_id'=>$user->id])->first();
              foreach($question->answers as $answer) {
                if($userData!=null){
                    if(in_array($answer->id, json_decode($userData->answers))){
                       $isSelected = true;
                    }

                    else{
                        $isSelected = false;
                    }
                }
                else{
                    $isSelected = false;
                }
                $answers[] = array(
                     'id'=>$answer->id,
                     'question_id'=>$answer->question_id,
                     'answer'=>$answer->answer,
                     'created_at'=>$answer->created_at,
                     'isSelected'=>$isSelected);
              }
              $data[]=array(
                'id'=>$question->id,'questions'=>$question->question,'type'=>$question->type
                ,'answers'=>$answers
            );
              $answers = null;
            }
            $UserInformations = UserInformation::where(['industry_id'=>$id,'user_id'=>$user->id])->get();
            if($UserInformations) {
                return response()->json(['data'=>$data,'industry'=>$industry ,'success'=>true]);
            } else {
                return response()->json(['data'=>null]);
            }

        } else {
            return response()->json(['data'=>null]);
        }


    }

    public function postProfile(Request $request, $id)
    {

            $someJSON = $request->question;
            if(!empty($request->question)){
                foreach ($someJSON as $key => $value) {
                $user = UserInformation::updateOrCreate([
                    'user_id' => Auth::user()->id,
                'industry_id'=> $id,
                'question_id' =>$key,
                ],[
                'user_id' => Auth::user()->id,
                'industry_id'=> $id,
                'question_id' =>$key,
                    'answers' =>json_encode($value),
                ]);
            }
            if($user)
            {
                return response()->json(['message'=>'Survey Updated Successfully!','success'=>true]);
            }
        }


	}
}
