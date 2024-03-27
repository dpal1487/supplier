<?php

namespace App\Http\Controllers;

use App\Models\{ProjectLink,  SupplierProject};
use App\Http\Resources\{ShowSupplierProjectResource, SupplierProjectResource};
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Exports\SupplierProjectReport;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    public function projects(Request $request)
    {
        $projects = SupplierProject::where('supplier_id', $this->uid());
        if (!empty($request->q)) {
            $projects = $projects->whereHas('project_link', function ($query) use ($request) {
                $query->where('project_name', 'like', "%$request->q%");
            });
        }
        return Inertia::render('Project/Index', [
            'suppliers' => SupplierProjectResource::collection($projects->paginate(10)->appends(request()->query())),
        ]);
    }
    public function show($id)
    {
        $project = ProjectLink::where('project_id', $id)->first();
        return Inertia::render('Project/Show', [
            'project' => new ShowSupplierProjectResource($project)
        ]);
    }
    public function report()
    {
        return Excel::download(new SupplierProjectReport($this->uid()), "ProjectReport.xlsx");
    }
}