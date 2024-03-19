<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Wallet, FeedbackCategory, Address, PanelSurvey, ReferralUser, NewsLetter, Report, ReportType, Respondent};
use App\Http\Resources\Panel\{PanelSurveyResource, NewsLetterResource};
use App\Http\Resources\RespondentResource;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private $data;
    public function index()
    {
        //return $this->getTokenId();
        $wallet = Wallet::where(['user_id' => $this->getTokenId()])->first();
        $wallet = array(
            'id' => $wallet->id,
            'date' => $wallet->date,
            'points' => $wallet->points,
            'cash_balance' => $wallet->cash_balance
        );
        return response()->json(['wallet' => $wallet]);
    }

    public function dailySurvey()
    {

        // $user =  Auth::user();

        // return $user;
        // $address = Address::where(['entity_id' => $user->id])->first();

        // return $address;
        // $panel_surveys = Respondent::with(['project' => function ($query) use ($address) {
        //     $query->where('status', '=', 'open');
        //     $query->where('country', '=', $address->country_id);
        // },])->paginate(10);
        


        $panel_surveys = Respondent::paginate(10);

        if ($panel_surveys) {
            return RespondentResource::collection($panel_surveys)->additional(['success' => true]);
        } else {
            return response()->json(['data' => null, 'meta' => null, 'success' => false]);
        }
    }

    public function newsLetter()
    {

        $news_letters = NewsLetter::where(['status' => '1'])->paginate(10);

        if (count($news_letters) > 0) {
            return NewsLetterResource::collection($news_letters)->additional(['success' => true]);
        } else {
            return response()->json(['data' => null, 'meta' => null, 'success' => false]);
        }
    }

    public function storeReport(Request $request)
    {

        $user = JwtAuth::user();
        $report = new Report();
        $report->user_id = $user->id;
        $report->type_id = '1';
        $report->source_id = $request->Id;
        $result  = $report->save();
        if ($result) {
            return response()->json(['message' => 'Report Submitted Successfully.', 'success' => true]);
        }
    }

    public function referralUser()
    {
        $user = JwtAuth::user();
        $result = ReferralUser::where(['user_id' => $user->id])->get();
        if ($result) {
            return response()->json(['data' => count($result), 'success' => true]);
        }
    }
    public function feedbackCategory()
    {
        $feedback_category = FeedbackCategory::all();
        if ($feedback_category) {
            return response()->json(['success' => true, 'data' => $feedback_category]);
        }
    }
}
