<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierProjectResource extends JsonResource
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
            'supplier' => new SupplierResource($this->supplier),
            'project_id' => $this->project?->project_id,
            'project_name' => $this->project_link?->project_name,
            'country' => new CountryResource($this->project_link?->country),
            'client' => new ClientResource($this->project_link?->project->client),
            'supplier_link' => $this->supplier_link,
            'sample_size' => $this->sample_size,
            'complete_url' => $this->complete_url,
            'terminate_url' => $this->terminate_url,
            'quotafull_url' => $this->quotafull_url,
            'security_terminate_url' => $this->security_terminate_url,
            'notes' => $this->notes,
            'status' => $this->status == 1 ? 'live' : 'pause',
            'cpi' =>  $this->project_link?->cpi,
            'loi' => $this->project_link?->loi,
            'ir' => $this->project_link?->ir,
            'created_at' => date('d/M/y-H:m:s A', strtotime($this->created_at)),
            'complete' => $this->complete ? count($this->complete) : 0,
        ];
    }
}
