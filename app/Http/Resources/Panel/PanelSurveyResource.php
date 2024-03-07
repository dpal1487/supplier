<?php

namespace App\Http\Resources;
use App\Models\Industries;
use App\Models\AgeGroup;
use App\Models\JobTitle;
use App\Models\Ethnicity;
use Illuminate\Http\Resources\Json\JsonResource;
class PanelSurveyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        'id'=>$this->id,
        'pid'=>$this->pid,
        'survey_name'=>$this->survey_name,
        'project_name'=>$this->project['project_name'],
        'country'=>$this->project['country'],
        'client_live_url'=>str_replace("RespondentID",'testing',$this->project['client_live_url']),
        'point'=>$this->point,
        'time'=>$this->project['time'],
        'status'=>$this->status,
        'job_titles'=>$this->job_titles($this->job_title_id),
        'industries'=>$this->industries($this->industry_id),
        'age_groups'=>$this->age_group($this->age_group_id),
        'ethnicities'=>$this->ethnicity($this->ethnicity_id),
        'created_at'=>date('d-m-Y', strtotime($this->created_at))
        ];
    }

    public function job_titles($datas)
    {
        return $data = JobTitle::whereIn('id', explode(',',$datas))->get();
    }
    public function industries($datas)
    {
        return $data = Industries::whereIn('id', explode(',',$datas))->get();
    }
    public function age_group($datas)
    {
        return $data = AgeGroup::whereIn('id', explode(',',$datas))->get();
    }
    public function ethnicity($datas)
    {
        return $data = Ethnicity::whereIn('id', explode(',',$datas))->get();
    }
}