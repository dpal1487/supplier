<?php

namespace App\Http\Controllers;

use App\Models\{Project, Supplier, Respondent, ProjectLink,  SupplierProject, ProjectActivity};
use App\Http\Resources\{ProjectResource, ProjectLinkResource, SupplierProjectResource, SupplierResource, SuppliersResponedentResource};
use App\Exports\{ProjectReport};
use Inertia\Inertia;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public function project($id)
    {
        $project = Project::find($id);

        return $project;
    }

    public function getSupplier($id)
    {
        $supplier = Supplier::where(['id' => $id])->first();
        return new SupplierResource($supplier);
    }
    public function index(Request $request)
    {
        $id = '80afbb87-3bb1-48d2-b9fa-07d86ae809a2';
        $respondents = Respondent::where('supplier_id', $id);

        if (!empty($request->q)) {
            $respondents = $respondents->whereHas('project', function ($query) use ($request) {
                $query->where('project_name', 'like', '%' . $request->q . '%');
            });
        }
        if (!empty($request->status) && $request->status != 'all') {
            $respondents = $respondents->where('status', $request->status);
        }

        return Inertia::render('Project/Index', [
            'projects' => SuppliersResponedentResource::collection($respondents->paginate(10)->appends(request()->query())),
            'supplier' => $this->getSupplier('80afbb87-3bb1-48d2-b9fa-07d86ae809a2'),
        ]);
    }



    public function report($id)
    {
        $project = Project::find($id);
        if ($project) {
            $activity = ProjectActivity::create([
                "project_id" => $id,
                "type_id" => "status",
                "text" =>  $project->project_name . " report download",
                "user_id"   => Auth::user()->id,
            ]);

            return Excel::download(new ProjectReport($id), $project->project_id . '-' . $project->project_name . '.xlsx');
        }
    }
}
