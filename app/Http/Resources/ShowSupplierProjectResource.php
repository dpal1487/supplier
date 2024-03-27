<?php

namespace App\Http\Resources;

use App\Models\Respondent;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowSupplierProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $collection = collect(Respondent::where('project_id', $this->project_id)->get());
        $terminate = $collection->where('status', 'terminate');
        $complete = $collection->where('status', 'complete');
        $security_terminate = $collection->where('status', 'security-terminate');
        $incomplete = $collection->where('status', NULL);
        $quotafull = $collection->where('status', 'quotafull');
        return [
            'id' => $this->id,
            'project_id' => $this->project->project_id,
            'project' => $this->project,
            'country' => new CountryResource($this->country),
            'client' => $this->project->client,
            'sample_size' => $this->sample_size,
            'project_link' => $this->project_link,
            'cpi' =>  $this->cpi,
            'loi' => $this->loi,
            'ir' => $this->ir,
            'status' => $this->status,
            'reports' => [
                'total_clicks' => $collection ? count($collection) : 0,
                'complete' => $complete ? count($complete) : 0,
                'terminate' => $terminate ? count($terminate) : 0,
                'quotafull' => $quotafull ?  count($quotafull) : 0,
                'incomplete' => $incomplete ?  count($incomplete) : 0,
                'security_terminate' => $security_terminate ?  count($security_terminate) : 0,
            ]
        ];
    }
}
