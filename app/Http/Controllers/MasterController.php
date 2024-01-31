<?php

namespace App\Http\Controllers;

use App\Exports\RespondentReport;
use App\Http\Resources\MasterResource;
use App\Http\Resources\UserResource;
use App\Models\CloseRespondent;
use App\Models\Respondent;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class MasterController extends Controller
{
    public function index(Request $request)
    {
        $surveys = Respondent::orderBy('created_at', 'desc')->where(['supplier_id' => Null]);
        $users = User::where('status', 1)->orderBy('first_name', 'asc')->get();
        $projects = Project::where('project_name', 'like', '%' . $request->q . '%')->get()->pluck('id');

        if (!empty($request->q)) {
            $projects = Project::where('project_name', 'like', '%' . $request->q . '%')->get()->pluck('id');
            $surveys = $surveys->whereIn('project_id', $projects);
            if ($surveys->count() > 0) {
                $surveys = $surveys;
            } else {
                $closeSurveys = CloseRespondent::orderBy('created_at', 'desc')->where('supplier_id', "=", Null)->whereIn('project_id', $projects);
                $closeSurveys = $closeSurveys->whereIn('project_id', $projects);
                $surveys = $closeSurveys;
            }
        }
        if (!empty($request->user)) {
            $surveys = $surveys->where('user_id', $request->user);
        }
        if (!empty($request->status)) {
            $surveys = $surveys->where('status', $request->status);
        }
        if (!empty($request->from_date)) {

            if (empty($request->to_date)) {
                $surveys = $surveys->whereDate('created_at', '>=', $request->from_date)
                    ->whereDate('created_at', '<=', date(now()));
            } else {
                $surveys = $surveys->whereDate('created_at', '>=', $request->from_date)
                    ->whereDate('created_at', '<=', $request->to_date);
            }
        }
        if (!empty($request->to_date)) {
            $surveys = $surveys->whereDate('created_at', '>=', $request->from_date)
                ->whereDate('created_at', '<=', $request->to_date);
        }
        $surveys = $surveys->paginate(200)->appends(request()->query());
      	$data = array();
      	foreach($users as $user)
        {
          $data[] = array(
          	'full_name' => $user->first_name." ".$user->last_name,
            'id'=> $user->id
          );
        }
        return Inertia::render('Master/Index', [
            'surveys' => MasterResource::collection($surveys),
            'users' => [
            'data'=>$data
            ]
        ]);
    }
    public function exportReport(Request $request)
    {
        return Excel::download(new RespondentReport($request), "RespondentReport.xlsx");
    }
}
