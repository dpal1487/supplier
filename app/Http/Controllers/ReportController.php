<?php

namespace App\Http\Controllers;

use App\Exports\RespondentReport;
use App\Http\Resources\ReportResource;
use App\Models\Respondent;
use App\Models\Project;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {

        $supplier = Supplier::where('id', '=', Auth::user()->id)->first();
        $surveys = Respondent::orderBy('created_at', 'desc')->where(['supplier_id' => $supplier->id]);
        $projects = Project::where('project_name', 'like', '%' . $request->q . '%')->get()->pluck('id');
        if (!empty($request->q)) {
            $projects = Project::where('project_name', 'like', '%' . $request->q . '%')->get()->pluck('id');
            $surveys = $surveys->whereIn('project_id', $projects);
        }
        if (!empty($request->status)) {
            $surveys = $surveys->where('status', $request->status);
        }
        if (!empty($request->from_date)) {

            if (empty($request->to_date)) {
                $surveys = $surveys->whereDate('created_at', '>=', $request->from_date)
                    ->whereDate('created_at', '<=', date(now()));
            } else {
                $surveys = $surveys->whereDate('created_at', '>=', $request->from_date)
                    ->whereDate('created_at', '<=', $request->to_date);
            }
        }
        if (!empty($request->to_date)) {
            $surveys = $surveys->whereDate('created_at', '>=', $request->from_date)
                ->whereDate('created_at', '<=', $request->to_date);
        }
        $surveys = $surveys->paginate(200)->appends(request()->query());

        return Inertia::render('Report/Index', [
            'surveys' => ReportResource::collection($surveys),
        ]);
    }

    public function exportReport(Request $request)
    {
        return Excel::download(new RespondentReport($request), "RespondentReport.xlsx");
    }
}