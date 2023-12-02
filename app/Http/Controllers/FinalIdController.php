<?php

namespace App\Http\Controllers;

use App\Exports\ExportFinalIDs;
use App\Exports\IdExport;
use App\Http\Resources\FinalIdsResource;
use App\Http\Resources\ProjectResource;
use App\Imports\IdImport;
use App\Models\FinalId;
use App\Models\Project;
use App\Models\Respondent;
use App\Models\SupplierSurvey;
use App\Models\Survey;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class FinalIdController extends Controller
{
    public function index(Request $request)
    {
        $finalId = FinalId::groupBy('project_id');
        if (!empty($request->q)) {
            $finalId = $finalId->whereHas('projects', function ($q) use ($request) {
                $q->where('project_name', 'like', "%$request->q%");
            });
        }
        $finalId = $finalId->paginate(10)->appends(request()->query());
        return Inertia::render('FinalIds/Index', [
            'filanids' => FinalIdsResource::collection($finalId),
        ]);
    }
    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            if (Excel::import(new IdImport($request->id), $request->file('file'))) {
                return response()->json(['success' => true, 'message' => 'Import file successfully']);
            }
            return response()->json(['success' => true, 'message' => 'Opps! something went wrong.']);
        }
    }
    public function export($id)
    {
        $project = Project::find($id);
        if (FinalId::where('project_id', $id)->first() && Respondent::where('project_id', $id)->first()) {
            return Excel::download(new ExportFinalIDs($id), $project->project_id . '.xlsx');
        }
        return redirect('/project');
    }
}
