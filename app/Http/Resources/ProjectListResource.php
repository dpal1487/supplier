<?php

namespace App\Http\Resources;

use App\Models\Respondent;
use App\Models\SupplierProject;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectListResource extends JsonResource
{

    public function toArray($request)
    {
        $projects = SupplierProject::where('supplier_id', $this->id)->get();
        $collection = collect(Respondent::where('supplier_id', $this->id)->get());
        $project = collect(ProjectResource::collection($this->projects));
        $terminate = $collection->where('status', 'terminate');
        $complete = $collection->where('status', 'complete');
        $security_terminate = $collection->where('status', 'security-terminate');
        $incomplete = $collection->where('status', NULL);
        $quotafull = $collection->where('status', 'quotafull');
        return [
            'id' => $this->id,
            'live' => count($project->where('status', 'live')),
            'pause' => count($project->where('status', 'hold')),
            'close' => count($project->where('status', 'close')),
            'report' => [
                'total_projects' => count($projects),
                'total_clicks' => count($collection),
                'completes' => count($complete),
                'terminates' => count($terminate),
                'quotafull' => count($quotafull),
                'incompletes' => count($incomplete),
                'security_terminates' => count($security_terminate),
                'total_ir' => (count($complete) > 0) ? intval((count($complete) / (count($complete) + count($terminate))) * 100) . '%' : '0%',
            ]
        ];
    }
}
