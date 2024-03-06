<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Respondent;
use App\Http\Controllers\Controller;
use App\Models\ProjectLink;
use Illuminate\Support\Facades\DB;
use Str;
use Stevebauman\Location\Facades\Location;
use Jenssegers\Agent\Agent;
use App\Models\SupplierProject;
use Illuminate\Support\Facades\Redirect;

class SurveyController extends Controller
{
    public $data;

    public function start(Request $request, $pid)
    {

        $ip = '162.159.24.227';
        $data = Location::get($ip);


        $agent = new Agent();
        $project = SupplierProject::where(['id' => $pid])->first();

        $projectLink = ProjectLink::where(['id' => $project->project_link_id])->first();

        $projectZipcodeArray = explode(' , ', $projectLink->zipcode);
        $projectStateArray = explode(' , ', $projectLink->state);
        $projectCityArray = explode(' , ', $projectLink->city);

        return $projectLink;
        if (count($projectLink->completes) < $projectLink->sample_size) {
            if ($projectLink->project->status == 'live' && $projectLink->status == 1) {
                if (!Respondent::where(['supplier_project_id' => $pid, 'user_id' => $request->uid])->first()) {
                    if (!Respondent::where(['supplier_project_id' => $pid, 'starting_ip' => $request->ip()])->first()) {
                        $respondent = Respondent::create([
                            'user_id' => $request->uid,
                            'project_id' => $project->project_id,
                            'supplier_id' => $project->supplier_id,
                            'project_link_id' => $project->project_link_id,
                            'supplier_project_id' => $project->supplier_project_id,
                            'starting_ip' => $request->ip(),
                            'supplier_project_id' => $pid,
                            'device' => $agent->device(),
                            'client_browser' => $agent->browser(),
                        ]);
                        if (!empty($projectLink->city)) {
                            if (in_array($data->cityName, $projectCityArray)) {
                                return "city found in project";
                                return Redirect::to(str_replace('RespondentID', $respondent->id, $project->security_terminate_url));
                            } else {
                                return "city not found in project";
                            }
                        }
                        // if (!empty($projectLink->state)) {
                        //     // return $data->regionName
                        //     if (in_array($data->regionName, $projectStateArray)) {
                        //         return "state found in project";
                        // return Redirect::to(str_replace('RespondentID', $respondent->id, $project->security_terminate_url));
                        //     }
                        //     if (false) {
                        //         return "state not found in project";
                        //     }
                        // }
                        // if (is_array($projectZipcodeArray)) {
                        //     if (in_array($data->zipCode, $projectZipcodeArray)) {
                        //         return "sdsad";
                        // return Redirect::to(str_replace('RespondentID', $respondent->id, $project->security_terminate_url));
                        //     }
                        // }
                        return Redirect::to(str_replace('RespondentID', $respondent->id, $projectLink->project_link));
                    }
                    $this->data = ['message' => "We're sorry, Duplicate IP Address Detected.", 'title' => 'IP Error'];
                } else {
                    $this->data = ['message' => 'You have already attempt this survey please try agian later.', 'title' => 'Already Attempt'];
                }
            } else {
                $this->data = ['message' => 'Project is not live please try again later.', 'title' => 'Not Live'];
            }
        } else {
            $this->data = ['message' => 'Thank you for your interest, we have reached our target number of participants.', 'title' => 'Quota Reached'];
        }
        return response()->json(['data' => $this->data]);
    }
}
