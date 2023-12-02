<?php

namespace App\Http\Resources;

use App\Models\FinalId;
use App\Models\Project;
use Illuminate\Http\Resources\Json\JsonResource;

class FinalIdsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    // $count = Final
    public function toArray($request)
    {
        $finalids = FinalId::get();

        return [
            'project_name' => $this?->project->project_name,
            'id' => $this->project_id,
            'count' => count($finalids->where('project_id', $this->project_id)),
            'complete' => $this->project?->complete->count(),
        ];
    }
}
