<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project?->project_id,
            'project_name' => $this->project->project_name,
            'vender' => $this->project->client,
            'project_link_id' => $this->project_link_id,
            'starting_ip' => $this->starting_ip,
            'end_ip' => $this->end_ip,
            'client_browser' => $this->client_browser,
            'device' => $this->device,
            'loi' => $this->project_link?->loi,
            'cpi' => $this->project_link?->cpi,
            'status' => $this->status,
            'created_at' => date('d-m-Y H:i:s', strtotime($this->created_at)),
            'end_date' => date('d-m-Y H:i:s', strtotime($this->updated_at)),
            'duration' => $this->created_at->diff($this->updated_at)->format('%H:%I:%S'),

        ];
    }
}
