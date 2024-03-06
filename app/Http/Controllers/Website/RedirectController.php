<?php

namespace App\Http\Controllers\Website;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Models\Surveys;
use App\Models\PartnerSurvey;
use App\Models\Projects;
use App\Models\PartnerProjects;
use App\Http\Controllers\Controller;
use App\Models\Respondent;
use App\Models\SupplierProject;
use App\Models\Survey;

class RedirectController extends Controller
{
    private $uid, $pid, $date, $result_url, $status, $response;
    public function __construct(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        $_GET = array_change_key_case($_GET, CASE_LOWER);
        $this->date = date('Y-m-d H:i:s');
        if (!isset($_GET['uid']) || !isset($_GET['pid'])) {
            return response()->json(['message' => 'Opps something went wrong!']);
        } else {
            $this->uid = $_GET['uid'];
            $this->pid = $_GET['pid'];
        }
    }
    public function status(Request $request)
    {
        $vendor = Respondent::where(['user_id' => $this->uid])->first();
        if (!empty($vendor)) {
            $url = SupplierProject::where(['project_id' => $vendor->project_id, 'supplier_id' => $vendor->partner_id])->first();
            if (!empty($vendor) && !empty($url)) {
                if ($vendor->status == null || empty($vendor->status)) {
                    $search = array("RespondentID", "toid");
                    $replace = array($vendor->toid, $vendor->pid);
                    if ($request->segment(4) == 'complete') {
                        $this->result_url = str_replace($search, $replace, $url->complete_url);
                        $this->status = 'complete';
                    } elseif ($request->segment(4) == 'terminate') {
                        $this->result_url = str_replace($search, $replace, $url->terminate_url);
                        $this->status = 'terminate';
                    } elseif ($request->segment(4) == 'quotafull') {
                        $this->result_url = str_replace($search, $replace, $url->quotafull_url);
                        $this->status = 'quotafull';
                    }
                    Respondent::where(array('user_id' => $this->uid))->update(array('status' => $this->status, 'end_ip' => $request->ip(), 'end_survey' => date('Y-m-d H:i:s')));
                    return response()->json(['redirect' => $this->result_url, 'success' => true, 'isVendor' => true]);
                } else {
                    return response()->json(['message' => 'Survey already completed.', 'success' => false]);
                }
            } else {
                return response()->json(['message' => 'Invalid parameters', 'success' => false]);
            }
        } else {
            return $this->redirect($request);
        }
    }
    public function redirect(Request $request)
    {
        $status = $request->segment(4);
        $survey = new Survey();
        $survey->uid = $this->uid;
        $survey->pid = $this->pid;
        $survey->ip_address = $this->ip();
        $survey->status = $status;
        $survey->date = $this->date;
        if (!empty($this->uid) && !empty($this->pid)) {
            if (!$survey->where(array("uid" => $this->uid, "pid" => $this->pid))->first()) {
                if ($survey->save()) {
                    $survey = $survey->where(array("id" => $survey->id))->first();
                    return response()->json(['success' => true, 'message' => 'Your survey has been ' . $survey->status, 'data' => $survey]);
                }
            } else {
                return response()->json(['message' => 'You have already attempted this survey.']);
            }
        } else {
            return response()->json(['message' => 'Parameters are not set correctly']);
        }
    }
    function ip()
    {
        //IP ADDRESS
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        $AgentIp = $ipaddress;

        return $AgentIp;
    }
}
