<?php

namespace App\Http\Controllers;

use App\Models\{Supplier, ProjectLink,  SupplierProject};
use App\Http\Resources\{SupplierProjectResource, SupplierResource};
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public function getSupplier($id)
    {
        $supplier = Supplier::where(['id' => $id])->first();
        return new SupplierResource($supplier);
    }


    public function projects(Request $request)
    {
        $id = Auth::user()->id;
        if ($this->getSupplier($id)) {
            $projects = SupplierProject::where('supplier_id', $id);
            if (!empty($request->q)) {

                $projects = $projects->whereHas('project_link', function ($query) use ($request) {
                    $query->where('project_name', 'like', "%$request->q%");
                });
            }
            return Inertia::render('Project/Index', [
                'supplier' => $this->getSupplier($id),
                'suppliers' => SupplierProjectResource::collection($projects->paginate(10)->appends(request()->query())),
            ]);
        }
    }

    public function show($id)
    {
        $project = ProjectLink::where('project_id', $id)->first();
        return Inertia::render('Project/Show', [
            'project' => $project
        ]);
    }
}
