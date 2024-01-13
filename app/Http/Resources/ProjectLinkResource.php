<?php

namespace App\Http\Resources;

use App\Models\CloseRespondent;
use App\Models\ProjectLink;
use App\Models\Respondent;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProjectLinkResource extends JsonResource
{
    public function toArray($request)
    {
        $closeProject = ProjectLink::where(['id' =>  $this->id])->first();
        if (!empty($closeProject)) {
            $collection = collect(CloseRespondent::where('project_link_id', $this->id)->get());
        } else {
            $collection = collect(Respondent::where('project_id', $this->id)->get());
        }
        $terminate = $collection->where('status', 'terminate');
        $complete = $collection->where('status', 'complete');
        $security_terminate = $collection->where('status', 'security-terminate');
        $incomplete = $collection->where('status', NULL);
        $quotafull = $collection->where('status', 'quotafull');
        return [
            'id' => $this->id,
            'state' => explode(' , ', $this->state),
            'city' => explode(' , ', $this->city),
            'project_uid' => $this->project->project_id,
            'project_name' => $this->project_name,
            'project_id' => $this->project_id,
            'user' => $this->user ?  $this->user?->first_name . ' ' . $this->user?->last_name : '',
            'project' => $this->project,
            'country' => new CountryResource($this->country),
            'project_country' => $this->country?->id,
            $zipcode = str_replace(' , ', ' ', $this->zipcode),
            'project_zipcode' => $zipcode,
            'sample_size' => $this->sample_size,
            'project_link' => $this->project_link,
            'cpi' => Auth::user()->role->role->slug != 'user' ? $this->cpi : '',
            'loi' => $this->loi,
            'ir' => $this->ir,
            'notes' => $this->notes,
            'status' => $this->status,
            'client' => $this->project->client,
            'supplier_count' => $this->suppliers ?  count($this->suppliers) : 0,
            'created_at' => date('d/M/y - H:m:s A', strtotime($this->created_at)),
            'reports' => [
                'total_clicks' => $collection ? count($collection) : 0,
                'complete' => $complete ? count($complete) : 0,
                'terminate' => $terminate ? count($terminate) : 0,
                'quotafull' => $quotafull ?  count($quotafull) : 0,
                'incomplete' => $incomplete ?  count($incomplete) : 0,
                'security_terminate' => $security_terminate ?  count($security_terminate) : 0,
                'total_ir' => (count($complete) > 0) ? intval((count($complete) / (count($complete) + count($terminate))) * 100) . '%' : '0%'
            ]
        ];
    }
}
