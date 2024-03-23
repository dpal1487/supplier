<?php

namespace App\Http\Resources;

use App\Models\ProjectLink;
use App\Models\Respondent;
use Illuminate\Http\Resources\Json\JsonResource;

class SuppliersResponedentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $collection = collect(Respondent::where('project_id', $this->id)->get());
        $complete = $collection->where('status', 'complete');
        return [
            'id' => $this->id,
            'project_id' => $this->project->project_id ?? $this->project_id,
            'project_name' => $this->project->project_name ?? '',
            'user' =>  $this->user_id,
            'supplier_name' => $this->supplier?->supplier_name,
            'supplier_project_id' => $this->supplier_project_id,
            'project_name' => $this->project_link?->project_name,
            'cpi' =>  $this->project_link?->cpi,
            'loi' => $this->project_link?->loi,
            'ir' => $this->project_link?->ir,
            'status' => $this->supplier?->status == 1 ? 'Live' : 'Offline',
            'country' => $this->supplier->country,
            'created_at' => date('d-m-Y H:i:s', strtotime($this->created_at)),
            'complete' => $complete ? count($complete) : 0,
        ];
    }
}
